<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Actions\SyncReviewScores;
use App\Events\ReviewCreated;
use App\Http\Requests\ValidateReviewRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Shows a single review
     */
    public function show(Document $document, Review $review)
    {
        $response = Gate::inspect('showReview', $review);
        if($response->allowed())
        {
            return view('reviews.show', [
                'document' => $document,
                'review' => $review,
                'fields' => $review->reviewFields,
            ]);
        }

        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Shows a table of reviews
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $response = Gate::inspect('reviewDashboard', Review::class);

        if($response->allowed())
        {
            if($user->can('reviews.manage'))
            {
                $reviewQuery = Review::query();
                $searchQuery = $request->get('search');

                $review = $reviewQuery->where('title', 'LIKE', '%' . $searchQuery . '%')
                ->orWhereHas('user', function($userQuery) use($searchQuery){
                    $userQuery->where('user_name', 'LIKE', '%' . $searchQuery . '%');
                });
            }
            else
            {
                $review = $user->review();
            }

            $review = $review->sortable()->paginate(15)->withQueryString();

            return view('reviews.index', ['reviews' => $review]);
        }

        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Shows a table of reviews from a given document
     */
    public function indexByDocument(Document $document)
    {
        $response = Gate::inspect('indexByDocument', [Review::class, $document]);

        if($response->allowed())
        {
            $reviews = $document->review()->paginate(15);
            return view('reviews.indexByDocument', ['document' => $document, 'reviews' => $reviews]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Shows review creation form
     */
    public function create(Document $document)
    {
        $response = Gate::inspect('createReview', [Review::class, $document]);
        if($response->allowed())
        {
            return view('reviews.create', [
                'document' => $document,
                'fields' => $document->submissionType->reviewFields
            ]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Stores review
     */
    public function store(ValidateReviewRequest $request, Document $document, SyncReviewScores $action)
    {
        $review = null;
        $event = $document->submission->event;
        $fields = $request->validated();

        if($request->hasFile('attachment'))
        {
            $fields['attachment'] = $request->file('attachment')->store('review_attachments', 'public');
        }
        DB::transaction(function() use ($fields, &$review, $action, $event){
            $reviewValues = $action->handle($fields, $event);
            $fields['score'] = $reviewValues[1];
            $fields['recommendation'] = $reviewValues[2];
            $review = Review::create($fields);
            $review->reviewFields()->sync($reviewValues[0]);
        });

        ReviewCreated::dispatch($document->submission, true);

        return redirect()->route('showReview', [$document, $review])->with('success', "Avaliação submetida.");
    }

    /**
     * Shows review editing form
     */
    public function edit(Document $document, Review $review)
    {
        $response = Gate::inspect('editReview', $review);

        if($response->allowed())
        {
            return view('reviews.edit', [
                'review' => $review,
                'document' => $document,
                'fields' => $document->submissionType->reviewFields
            ]);
        }

        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Saves review changes
     */
    public function update(ValidateReviewRequest $request, Document $document, Review $review, SyncReviewScores $action)
    {
        $fields = $request->validated();

        $reviewValues = $action->handle($fields, $document->submission->event);
        $fields['score'] = $reviewValues[1];
        $fields['recommendation'] = $reviewValues[2];
        
        if($request->hasFile('attachment'))
        {
            $fields['attachment'] = $request->file('attachment')->store('review_attachments', 'public');
        }

        $review->update($fields);
        $review->reviewFields()->sync($reviewValues[0]);
        $changed = $review->wasChanged('recommendation');
        ReviewCreated::dispatch($document->submission, $changed);

        return redirect()->route('showReview', ['review' => $review, 'document' => $document])->with('success', "Avaliação atualizada.");
    }

    /**
     * Delete review
     */
    public function destroy(Document $document, Review $review)
    {
        $response = Gate::inspect('deleteReview', $review);

        if($response->allowed())
        {
            $review->delete();
            ReviewCreated::dispatch($document->submission, true);
            //event (new ReviewCreated($document->submission, true));
            return redirect()->back()->with('success', 'Avaliação de ' . $document->title . ' removida.');
        }

        return redirect()->back()->with('error', $response->message());
    }
}
