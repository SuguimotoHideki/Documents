<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Events\ReviewCreated;

class ReviewerController extends Controller
{
    public function create(Document $document)
    {
        $this->authorize('assignReviewer', Review::class);

        $users = User::role('reviewer')->where('id', '!=', 1)->get();
        return view('reviews.assignReviewer',[
            'document' => $document,
            'users' => $users
        ]);
    }

    public function store(Request $request, Document $document)
    {
        $this->authorize('assignReviewer', Review::class);

        $reviewers = $document->users()->pluck('user_id')->toArray();

        $parameters = $request['permissions'];
        foreach($parameters as $userId => $permissions)
        {
            $user = User::find($userId);
            if($permissions[0] === '1')
            {
                if(!$document->users->contains($user))
                {
                    $document->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);
                }
            }
            else
            {
                $document->users()->detach($user->id);
            }
        }

        $newReviewers = $document->users()->pluck('user_id')->toArray();
        $changed = ($reviewers !== $newReviewers);
        ReviewCreated::dispatch($document->submission, $changed);

        return back()->with('success', 'Permissões aplicadas.');
    }
}
