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
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    //Return all documents
    public function index()
    {
        $user = Auth::user();

        $response = Gate::inspect('indexDocument', Document::class);

        if($response->allowed())
        {
            if($user->hasRole(['admin', 'event moderator']))
            {
                $userDocuments = Document::sortable()->paginate();
            }
            elseif($user->hasRole('reviewer'))
            {
                $userDocuments = $user->documents()->sortable()->paginate();
            }
            return view('documents.index', [
                'documents' => $userDocuments
            ]);
        }
        return redirect()->back()->with('error', $response->message());
    }
    
    //Return single document
    public function show(Document $document)
    {
        $response = Gate::inspect('showDocument', $document);
        if($response->allowed())
        {
            return view('documents.show',[
                'document' => $document
            ]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    //Returns document form view
    public function create(Event $event)
    {
        $response = Gate::inspect('createDocument', [Document::class, $event]);
        if($response->allowed())
        {
            return view('documents.create', compact('event'));
        }
        return redirect()->back()->with('error', $response->message());
    }

    //Stores document
    public function store(Request $request, CreateCoAuthor $coAction, CreateSubmission $subAction)
    {
        $validationRules = [
            'title' => ['required', 'string', Rule::unique('documents', 'title')],
            'keyword' => ['required', 'string'],
            'institution' => ['required', 'string'],
            'submission_type_id' => ['required', 'numeric'],
            'attachment_author' => ['required'],
            'attachment_no_author' => ['required']
        ];

        $formFields = $request->validate($validationRules);

        //dd($request, $formFields);

        $formFields['attachment_author'] = $request->file('attachment_author')->store('submission_attachments', 'public');
        $formFields['attachment_no_author'] = $request->file('attachment_no_author')->store('submission_attachments_no_author', 'public');

        //Retrieves the current user and the event
        $redirect = null;
        $user = Auth::user();
        $event = Event::findOrFail($request['event_id']);

        //Creates new document instance, co-authors and submission instance.
        //Creates entries in the pivot tables between users, events, documents, and co-authors
        DB::transaction(function() use ($coAction, $subAction, $request, $formFields, $event, $user, &$redirect){
            $document = Document::create([
                'title' => $formFields['title'],
                'keyword' => $formFields['keyword'],
                'institution' => $formFields['institution'],
                'submission_type_id' => $formFields['submission_type_id'],
                'attachment_author' => $formFields['attachment_author'],
                'attachment_no_author' => $formFields['attachment_no_author'],
            ]);

            $subAction->handle($document, $event, $user);

            $redirect = $coAction->handle($request, $document, $user, $event);
        });

        return $redirect;
    }

    //Show document edit form
    public function edit(Document $document)
    {
        $response = Gate::inspect('editDocument', $document);
        if($response->allowed())
        {
            return view('documents.edit',[
                'document' => $document
            ]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    //Uodate document fields
    public function update(Request $request, Document $document, UpdateCoAuthor $action)
    {

        $formFields = $request->validate([
            'title' => ['required', 'string', Rule::unique('documents', 'title')->ignore($document->id)],
            'keyword' => ['required', 'string'],
            'institution' => ['required', 'string'],
            'submission_type_id' => ['required', 'numeric']
        ]);

        if($request->hasFile('attachment_author'))
        {
            $formFields['attachment_author'] = $request->file('attachment_author')->store('submission_attachments', 'public');
            $document->update($formFields);
        }
        else
        {
            $document->update($request->except('attachment_author'));
        }

        if($request->hasFile('attachment_no_author'))
        {
            $formFields['attachment_no_author'] = $request->file('attachment_no_author')->store('submission_attachments_no_author', 'public');
            $document->update($formFields);
        }
        else
        {
            $document->update($request->except('attachment_no_author'));
        }

        if($document->wasChanged())
        {
            $document->submission->touch();
        }

        return $action->handle($request, $document);
    }

    public function destroy(Document $document)
    {
        $response = Gate::inspect('deleteDocument', $document);

        if($response->allowed())
        {
            $document->delete();
            return redirect()->back()->with('success', 'Submissão ' . $document->title . ' removida.');
        }
        return redirect()->back()->with('error', $response->message());
    }
}
