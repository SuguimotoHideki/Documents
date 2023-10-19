<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Actions\SyncReviewScores;
use App\Events\ReviewCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;

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
                'fields' => $document->review->reviewFields,
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

            $review = $review->paginate(15)->withQueryString();

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
    public function store(Request $request, Document $document, SyncReviewScores $action)
    {
        $review = null;

        $formFields = $request->validate([
            'title' => ['required', 'string'],
            'score.*' => ['required', 'integer', 'digits_between:0,10'],
            'comment' => ['required', 'string'],
            'moderator_comment' => ['nullable', 'string'],
            'recommendation' => ['required'],
            'user_id' => ['required'],
            'document_id' => ['required']
        ]);

        if($request->hasFile('attachment'))
        {
            $formFields['attachment'] = $request->file('attachment')->store('review_attachments', 'public');
        }

        try
        {
            DB::transaction(function() use ($formFields, &$review, $action){
                $reviewValues = $action->handle($formFields);

                $formFields['score'] = $reviewValues[1];

                $review = Review::create($formFields);

                $review->reviewFields()->sync($reviewValues[0]);
            });
        }
        catch(QueryException $error)
        {
            if($error->getCode() === '23000')
            {
                return redirect()->back()->with('error', 'Você já avaliou a submissão ' . $document->title . '.');
            }
            else {
                // Other database-related error occurred
                return redirect()->back()->with('error', 'Ocorreu um erro ao criar a avaliação.');
            }
        }

        event (new ReviewCreated($document->submission, true));

        return redirect()->route('showReview', [$document, $review])->with('success', "Avaliação submetida.");
    }

    /**
     * Shows review edition form
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
    public function update(Request $request, Document $document, Review $review, SyncReviewScores $action)
    {
        $formFields = $request->validate([
            'title' => ['required', 'string'],
            'comment' => ['required', 'string'],
            'score' => ['required', 'array'],
            'score.*' => ['required', 'integer', 'digits_between:0,10'],
            'moderator_comment' => ['nullable', 'string'],
            'recommendation' => ['required'],
        ]);

        $reviewValues = $action->handle($formFields);

        $formFields['score'] = $reviewValues[1];

        if($request->hasFile('attachment'))
        {
            $formFields['attachment'] = $request->file('attachment')->store('review_attachments', 'public');
        }

        $review->update($formFields);

        $review->reviewFields()->sync($reviewValues[0]);

        $changed = $review->wasChanged('recommendation');

        event (new ReviewCreated($document->submission, $changed));

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

            event (new ReviewCreated($document->submission, true));

            return redirect()->back()->with('success', 'Avaliação de ' . $document->title . ' removida.');
        }

        return redirect()->back()->with('error', $response->message());
    }
}
