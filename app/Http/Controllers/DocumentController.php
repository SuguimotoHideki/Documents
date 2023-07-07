<?php

namespace App\Http\Controllers;

use App\Models\CoAuthor;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\File\Exception\FormSizeFileException;

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
        dd($request);
        $validationRules = [
            'title' => ['required', 'string', Rule::unique('documents', 'title')],
            'abstract' => ['required', 'string'],
            'keyword' => ['required', 'string'],
            'document_institution' => ['required', 'string'],
            'document_type' => ['required', 'string']
        ];

        for($i=1; $i<=8; ++$i)
        {
            $authorName = "author_{$i}_name";
            $authorEmail = "author_{$i}_email";
            $validationRules[$authorName] = ['nullable', 'string'];
            $validationRules[$authorEmail] = ['nullable', 'string'];
        }

        //dd($validationRules);
            $formFields = $request->validate($validationRules);

            //dd($formFields, $validationRules);

        if($request->hasFile('document'))
        {
            $formFields['document'] = $request->file('document')->store('documents', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Document::create([
            'title' => $formFields['title'],
            'abstract' => $formFields['abstract'],
            'keyword' => $formFields['keyword'],
            'document_institution' => $formFields['document_institution'],
            'document_type' => $formFields['document_type'],
            'document' => $formFields['document'],
            'user_id' => $formFields['user_id']
        ]);
        /*for($i=1; $i<=8; ++$i)
        {
            CoAuthor::create([
                'name' => $formFields['author_{$i}_name'],
                'last_name' => $formFields['author_{$i}_name'],
                'email' => $formFields['author_{$i}_email'],
            ]);
        }*/

        return redirect('/')->with('message', "Submissão enviada.");
    }

    //Show document edit form
    public function edit(Document $document)
    {
        return view('documents.edit',[
            'document' => $document
        ]);
    }

    //Uodate document fields
    public function update(Request $request, Document $document)
    {
        $formFields = $request->validate([
            'title' => ['required', 'string', Rule::unique('documents', 'title')->ignore($document->id)],
            'author' => ['required', 'string'],
            'abstract' => ['required', 'string'],
            'keyword' => ['required', 'string'],
            'document_institution' => ['required', 'string'],
            'document_type' => ['required', 'string']
        ]);

        if($request->hasFile('document'))
        {
            $formFields['document'] = $request->file('document')->store('documents', 'public');
            $document->update($formFields);
        }
        else
        {
            $document->update($request->except('document'));
        }

        return redirect()->route('showDocument', [$document])->with('message', "Submissão atualizada.");
    }
}
