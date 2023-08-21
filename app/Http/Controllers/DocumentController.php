<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Actions\CreateCoAuthor;
use App\Actions\UpdateCoAuthor;
use Illuminate\Validation\Rule;
use App\Actions\CreateSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    //Return all documents
    public function index()
    {
        $user = Auth::user();

        if($user->hasRole('admin'))
        {
            $userDocuments = Document::sortable()->paginate();
        }
        else
        {
            $userId = $user->id;
            $userDocuments = Document::where('user_id', $userId)->sortable()->paginate();
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
    public function create(Event $event)
    {
        return view('documents.create', compact('event'));
    }

    //Stores document
    public function store(Request $request, CreateCoAuthor $coAction, CreateSubmission $subAction)
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

        //Retrieves the current user and the event
        $redirect = null;
        $user = Auth::user();
        $event = Event::findOrFail($request['event_id']);

        //Creates new document instance, co-authors and submission instance.
        //Creates entries in the pivot tables between users, events, documents, and co-authors
        DB::transaction(function() use ($coAction, $subAction, $request, $formFields, $event, $user, &$redirect){
            $document = Document::create([
                'title' => $formFields['title'],
                'abstract' => $formFields['abstract'],
                'keyword' => $formFields['keyword'],
                'document_institution' => $formFields['document_institution'],
                'document_type' => $formFields['document_type'],
                'document' => $formFields['document'],
            ]);

            $subAction->handle($document, $event, $user);

            $redirect = $coAction->handle($request, $document, $user, $event);
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

        if($document->wasChanged())
        {
            $document->submission->touch();
        }

        return $action->handle($request, $document);
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->back()->with('message', 'Submissão ' . $document->title . ' removida.');
    }
}
