<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $submissions = $user->submission()->get();

        return view('submissions.index', ['user' => $user, 'submissions' => $submissions]);
    }
}
