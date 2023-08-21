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
        $sort = $request['sort'];

        if (strpos($sort, '.') !== false) {
            [$model, $column] = explode(".", $sort);
        } else {
            $column = $sort;
            $model = null;
        }

        $direction = $request['direction'];

        if($model !== null && $column !== null && $direction !== null)
        {
            $submissions = $user->submission()
            ->with($model)
            ->sortable([$request['sort'] => $direction])
            ->paginate();
        }
        else
        {
            $submissions = $user->submission()->sortable()->paginate();
        }

        return view('submissions.index', ['user' => $user, 'submissions' => $submissions]);
    }

    public function indexByEvent(Request $request, Event $event)
    {
        $submissions = $event->submission()->sortable()->paginate();

        return view('submissions.indexByEvent', ['event' => $event, 'submissions' => $submissions]);
    }

}