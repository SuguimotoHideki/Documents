<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Document;
use Illuminate\Http\Request;
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
            return view('reviews.show', ['document' => $document, 'review' => $review]);
        }

        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Shows a table of reviews
     */
    public function index()
    {
        $user = Auth::user();

        $response = Gate::inspect('reviewDashboard', Review::class);

        if($response->allowed())
        {
            if($user->can('reviews.manage'))
            {
                $review = Review::all();
            }
            else
            {
                $review = $user->review()->paginate();
            }
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
            $review = $document->review()->paginate();
            return view('reviews.indexByDocument', ['document' => $document, 'reviews' => $review]);
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
            return view('reviews.create', ['document' => $document]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Stores review
     */
    public function store(Request $request, Document $document)
    {
        $review = null;

        $formFields = $request->validate([
            'title' => ['required', 'string'],
            'score' => ['required', 'max:10', 'min:0', 'numeric'],
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
            DB::transaction(function() use ($formFields, &$review){
                $review = Review::create($formFields);
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
            return view('reviews.edit', ['review' => $review, 'document' => $document]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    /**
     * Saves review changes
     */
    public function update(Request $request, Document $document, Review $review)
    {
        $formFields = $request->validate([
            'title' => ['required', 'string'],
            'score' => ['required', 'max:10', 'min:0', 'numeric'],
            'comment' => ['required', 'string'],
            'moderator_comment' => ['nullable', 'string'],
            'recommendation' => ['required'],
        ]);

        if($request->hasFile('attachment'))
        {
            $formFields['attachment'] = $request->file('attachment')->store('review_attachments', 'public');
            $review->update($formFields);
        }
        else
        {
            $review->update($request->except('attachment'));
        }
        return redirect()->route('showReview', ['review' => $review, 'document' => $document])->with('success', "Avaliação atualizada.");
    }

    /**
     * Delete review
     */
    public function destroy(Document $document, Review $review)
    {
        $response = Gate::inspect('deleteReview', [Document::class, $review]);

        if($response->allowed())
        {
            $review->delete();
            return redirect()->back()->with('success', 'Avaliação de ' . $document->title . ' removida.');
        }
        return redirect()->back()->with('error', $response->message());
    }
}
