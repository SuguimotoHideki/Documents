<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Actions\CreateCoAuthor;
use App\Actions\UpdateCoAuthor;
use Illuminate\Validation\Rule;
use App\Actions\CreateSubmission;
use App\Http\Requests\ValidateDocumentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    //Return all documents
    public function index(Request $request)
    {
        $user = Auth::user();
        $response = Gate::inspect('indexDocument', Document::class);
        if($response->allowed())
        {
            $documents = null;
            $searchQuery = $request->get('search');
            if($user->hasRole(['admin']))
            {
                $documents = Document::getAllDocuments($searchQuery);
            }
            elseif($user->hasRole('event moderator'))
            {
                $documents = Document::getModeratedDocuments($searchQuery, $user);
            }
            elseif($user->hasRole('reviewer'))
            {
                $documents = Document::getReviewerDocuments($searchQuery, $user);
            }
            $documents = $documents->paginate(15)->withQueryString();
            return view('documents.index', [
                'documents' => $documents,
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
    public function store(ValidateDocumentRequest $request, CreateCoAuthor $createCoAuthor, CreateSubmission $createSub)
    {
        $fields =$request->validated();
        if($fields->hasFile('attachment_author'))
        {
            $fields = array_merge($fields, [
                'attachment_author' => $request->file('attachment_author')->store('submission_attachments', 'public')
            ]);
        }
        if($fields->hasFile('attachment_no_author'))
        {
            $fields = array_merge($fields, [
                'attachment_no_author' => $request->file('attachment_no_author')->store('submission_attachments_no_author', 'public')
            ]);
        }

        //Creates new document instance, co-authors and submission instance.
        //Creates entries in the pivot tables between users, events, documents, and co-authors
        DB::transaction(function() use ($createCoAuthor, $createSub, $request, $fields, &$redirect){
            $document = Document::create($fields);
            $user = Auth::user();
            $event = Event::findOrFail($request['event_id']);
            $createSub->handle($document, $event, $user);
            $createCoAuthor->handle($request, $document, $user, $event);
        });

        return redirect()->route('indexSubmissions', ['user' => Auth::user()])->with('success', 'Submissão enviada.');
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

    //Update document fields
    public function update(ValidateDocumentRequest $request, Document $document, UpdateCoAuthor $updateCoAuthor)
    {
        $fields =$request->validated();
        if($request->hasFile('attachment_author'))
        {
            $fields = array_merge($fields, [
                'attachment_author' => $request->file('attachment_author')->store('submission_attachments', 'public')
            ]);
        }
        if($request->hasFile('attachment_no_author'))
        {
            $fields = array_merge($fields, [
                'attachment_no_author' => $request->file('attachment_no_author')->store('submission_attachments_no_author', 'public')
            ]);
        }
        $document->update($fields);
        
        if($document->wasChanged())
            $document->submission->touch();
        return $updateCoAuthor->handle($request, $document);
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
