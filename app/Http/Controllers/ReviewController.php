<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    //
    public function show(Document $document, Review $review)
    {
        return view('reviews.show', ['document' => $document, 'review' => $review]);
    }

    public function index()
    {
        $review = Review::all();
        return view('reviews.index', ['reviews' => $review]);
    }

    public function indexByDocument(Document $document)
    {
        $review = $document->review()->paginate();
        return view('reviews.indexByDocument', ['document' => $document, 'reviews' => $review]);
    }

    public function create(Document $document)
    {
        $response = Gate::inspect('createReview', $document);
        if($response->allowed())
        {
            return view('reviews.create', ['document' => $document]);
        }
        return redirect()->back()->with('error', $response->message());
    }

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
            $review = Review::create($formFields);
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
        return redirect()->route('showReview', [$review, $document])->with('success', "Avaliação submetida.");
    }

    public function edit(Document $document, Review $review)
    {
        $response = Gate::inspect('editReview', $document);
        if($response->allowed())
        {
            return view('reviews.edit', ['review' => $review, 'document' => $document]);
        }
        return redirect()->back()->with('error', $response->message());
    }

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
}
