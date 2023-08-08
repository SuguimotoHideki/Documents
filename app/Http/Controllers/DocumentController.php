<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Actions\CreateCoAuthor;
use App\Actions\UpdateCoAuthor;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request, CreateCoAuthor $action)
    {
        $validationRules = [
            'title' => ['required', 'string', Rule::unique('documents', 'title')],
            'abstract' => ['required', 'min:100'],
            'keyword' => ['required', 'string'],
            'document_institution' => ['required', 'string'],
            'document_type' => ['required', 'string']
        ];

        $formFields = $request->validate($validationRules);

        if($request->hasFile('document'))
        {
            $formFields['document'] = $request->file('document')->store('documents', 'public');
        }

        $user = Auth::user();
        $redirect = null;

        DB::transaction(function() use ($action, $request, $formFields, $user, &$redirect){
            $document = Document::create([
                'title' => $formFields['title'],
                'abstract' => $formFields['abstract'],
                'keyword' => $formFields['keyword'],
                'document_institution' => $formFields['document_institution'],
                'document_type' => $formFields['document_type'],
                'document' => $formFields['document'],
            ]);

            $document->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);

            $redirect = $action->handle($request, $document);
        });

        return $redirect;
    }

    //Show document edit form
    public function edit(Document $document)
    {
        return view('documents.edit',[
            'document' => $document
        ]);
    }

    //Uodate document fields
    public function update(Request $request, Document $document, UpdateCoAuthor $action)
    {

        $formFields = $request->validate([
            'title' => ['required', 'string', Rule::unique('documents', 'title')->ignore($document->id)],
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

        return $action->handle($request, $document);
    }
}
