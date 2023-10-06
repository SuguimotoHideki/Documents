<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    //
    public function index(Request $request, User $user)
    {
        $submissions = $user->submission()->sortable()->paginate(15);

        return view('submissions.index', ['user' => $user, 'submissions' => $submissions]);
    }

    public function indexByEvent(Request $request, Event $event)
    {
        $submissions = $event->submission()->sortable()->paginate(15);

        return view('submissions.indexByEvent', ['event' => $event, 'submissions' => $submissions]);
    }

}