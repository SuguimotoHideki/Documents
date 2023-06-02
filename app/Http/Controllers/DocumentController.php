<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class DocumentController extends Controller
{
    //Get all documents
    /*public function index()
    {
        return view('documents.index', [
            'documents' => Document::all()
        ]);
    }*/

    //Return all documents
    public function index()
    {
        $user = Auth::user();

        if($user->hasRole('admin'))
        {
            $userDocuments = Document::all();
        }
        else
        {
            $userId = $user->id;
            $userDocuments = Document::where('user_id', $userId)->get();
        }
        return view('documents.index', [
            'documents' => $userDocuments
        ]);
    }
    
    //Return single document
    public function show(Document $document)
    {
        //dd($document);
        return view('documents.show',[
            'document' => $document
        ]);
    }

    //Returns document form view
    public function create()
    {
        return view('documents.create');
    }

    //Store document
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required', 'string', Rule::unique('documents', 'title')],
            'author' => ['required', 'string'],
            'advisor' => ['required', 'string'],
            'abstract' => ['required', 'string'],
            'keyword' => ['required', 'string'],
            'document_institution' => ['required', 'string'],
            'document_type' => ['required', 'string']
        ]);

        if($request->hasFile('document'))
        {
            $formFields['document'] = $request->file('document')->store('documents', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Document::create($formFields);

        return redirect('/')->with('message', "Document published.");
    }

    public function edit(Document $document)
    {
        return view('documents.edit',[
            'document' => $document
        ]);
    }
}
