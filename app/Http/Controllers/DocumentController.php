<?php

namespace App\Http\Controllers;

use App\Models\CoAuthor;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    //Returns user submissions
    public function userSubmission()
    {
        $user = Auth::user();

        $submissions = $user->documents()->sortable()->paginate();

        return view('documents.indexSubmitted', [
            'documents' => $submissions
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
        $validationRules = [
            'title' => ['required', 'string', Rule::unique('documents', 'title')],
            'abstract' => ['required', 'min:100'],
            'keyword' => ['required', 'string'],
            'document_institution' => ['required', 'string'],
            'document_type' => ['required', 'string']
        ];

        for($i=0; $i<7; ++$i)
        {
            $authorName = "author_{$i}_name";
            $authorEmail = "author_{$i}_email";
            $validationRules[$authorName] = ['nullable', 'string', 'required_with:' . $authorEmail];
            $validationRules[$authorEmail] = ['nullable', 'string', 'required_with:' . $authorName];
        }

        $formFields = $request->validate($validationRules);

        if($request->hasFile('document'))
        {
            $formFields['document'] = $request->file('document')->store('documents', 'public');
        }

        try
        {
            $document = Document::create([
                'title' => $formFields['title'],
                'abstract' => $formFields['abstract'],
                'keyword' => $formFields['keyword'],
                'document_institution' => $formFields['document_institution'],
                'document_type' => $formFields['document_type'],
                'document' => $formFields['document'],
            ]);
    
            $this->createCoAuthors($formFields, $document);
            $this->assignUser($document);
    
            return redirect()->route('indexSubmittedDocuments', ['user' => Auth::user()])->with('message', 'Submissão enviada.');
        }
        catch(\Exception $e)
        {
            $document->delete();
            return back()->with('error', 'Ocorreu um erro ao criar a submissão. Por favor, tente novamente.');
        }
    }

    //Assign document to authenticated user
    private function assignUser(Document $document)
    {
        $user = Auth::user();

        $document->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);
    }

    //Create and assign co-authors
    private function createCoAuthors($formFields, Document $document)
    {
        for($i=0; $i < 7; ++$i)
        {
            if($formFields["author_{$i}_name"] !== null && $formFields["author_{$i}_email"] !== null)
            {
                $coAuthor = CoAuthor::firstOrCreate([
                    'email' => $formFields["author_{$i}_email"],
                    'name' => $formFields["author_{$i}_name"],
                ]);
                $document->coAuthors()->attach($coAuthor->id, ['created_at' => now(), 'updated_at' => now()]);
            }
        }
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
