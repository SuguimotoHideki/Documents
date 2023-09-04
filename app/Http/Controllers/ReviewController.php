<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ReviewController extends Controller
{
    //
    public function index()
    {
        $review = Review::all();
        return view('reviews.index', ['reviews' => $review]);
    }

    public function indexByDocument(Document $document)
    {
        $review = $document->review()->paginate();
        return view('reviews.indexByDocument', ['reviews' => $review]);
    }

    public function create(Document $document)
    {
        return view('reviews.create', ['document' => $document]);
    }

    public function store(Request $request, Document $document)
    {

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
            Review::create($formFields);
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
        return redirect()->back();
    }
}
