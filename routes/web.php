<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'web' middleware group. Make something great!
|
*/

/*Get home page
Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/welcome', function()
{
    return view('welcome');
});

Route::get('/', [EventController::class, 'index'])->name('home')->middleware('auth');

//USERS//
Route::group(['middleware' => ['auth', 'id_or_permission:manage any user']], function()
{
    //Show user edit page
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('editUser');
    //Submit edited user information to update
    Route::put('/users/{user}/update', [UserController::class, 'update'])->name('updateUser');
    //Show user password change page
    Route::get('/users/{user}/edit-password', [UserController::class, 'editPassword'])->name('editPassword');
    //Submit new user password to update
    Route::put('/users/{user}/update-password', [UserController::class, 'updatePassword']);
    //Show single user
    Route::get('/users/{user}', [UserController::class, 'show'])->name('showUser');
});
//Show all users
Route::get('/manage/users', [UserController::class, 'index'])->name('manageUsers')->middleware('auth', 'can:manage any user');

//DOCUMENTS
Route::group(['middleware' => ['auth']], function()
{
    //Show document form view
    Route::get('/event/{event}/documents/create', [DocumentController::class, 'create'])->name('createDocument');
    //Publish document
    Route::post('documents', [DocumentController::class, 'store'])->name('storeDocument');
    //Show all documents
    Route::get('/manage/documents', [DocumentController::class, 'index'])->name('manageDocuments');
    //Show single document
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('showDocument');
    //Show document edit page
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('editDocument');
    //Update document
    Route::put('/documents/{document}/update', [DocumentController::class, 'update'])->name('updateDocument');
    //Delete document
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('deleteDocument');
    //Get documents submitted by the user
    Route::get('/users/{user}/documents/submitted', [SubmissionController::class, 'index'])->name('indexSubmissions');
});

Route::group(['middleware' => ['auth']], function()
{
    //EVENTS
    //Show event form view
    Route::get('/events/create', [EventController::class, 'create'])->name('createEvent');
    //Store new event
    Route::post('events', [EventController::class, 'store'])->middleware('auth');
    //Show all events
    Route::get('/events', [EventController::class, 'index'])->name('indexEvents');
    //Show event dashboard
    Route::get('/manage/events', [EventController::class, 'dashboard'])->name('manageEvents');
    //Show single event
    Route::get('/events/{event}', [EventController::class, 'show'])->name('showEvent');
    //Edit event form
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('editEvent');
    //Publish event update
    Route::put('/events/{event}/update', [EventController::class, 'update'])->name('updateEvent');
    //Delete event
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('deleteEvent');
    //Add moderator
    Route::get('/manage/events/{event}/moderators', [EventController::class, 'eventModerator'])->name('eventModerator');
    //
    Route::post('/manage/events/{event}', [EventController::class, 'addModerator'])->name('addModerator');

    //EVENT USER
    //Create relationship between event and logged user
    Route::post('/events/{event}', [EventController::class, 'subscribe'])->name('eventSubscribe');
    //Cancel user's subscription
    Route::post('/events/{event}/cancel-subscription', [EventController::class, 'cancelSubscription'])->name('cancelSubscription');
    //Get event's subscribers
    Route::get('/manage/events/{event}/subscribers', [EventController::class, 'subscribedUsers'])->name('indexSubscribers')->middleware('can:manage any event');
    //Get event's submissions
    Route::get('/manage/events/{event}/submissions', [SubmissionController::class, 'indexByEvent'])->name('indexEventSubmissions');
    //Get events subscribed by the logged user
    Route::get('/users/{user}/events/subscribed', [EventController::class, 'subscribedEvents'])->name('indexSubscribedEvents');
});