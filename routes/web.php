<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//USERS//

//Show user edit page
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('editProfile')->middleware("auth", "role_or_id");

//Submit edited user information to update
Route::put('/users/{user}/update', [UserController::class, 'update'])->middleware("auth", "role_or_id");

//Show user password change page
Route::get('/users/{user}/edit-password', [UserController::class, 'editPassword'])->name('editPassword')->middleware("auth", "role_or_id");

//Submit new user password to update
Route::put('/users/{user}/update-password', [UserController::class, 'updatePassword'])->middleware("auth", "role_or_id");

//Show single user
Route::get('/users/{user}', [UserController::class, 'show'])->name('showProfile')->middleware("auth", "role_or_id:admin");

//Show all users
Route::get('/users', [UserController::class, 'index'])->name('indexUsers')->middleware("auth", "role:admin");

//DOCUMENTS//
//Show document form view
Route::get('/documents/create', [DocumentController::class, 'create'])->name('createDocument')->middleware("auth");

//Publish document
Route::post('documents', [DocumentController::class, 'store'])->middleware("auth");

//Show all documents
Route::get('/documents', [DocumentController::class, 'index'])->name('indexDocuments');

//Show single document
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('showDocument')->middleware("auth");

//Show document edit page
Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('editDocument')->middleware("auth");

//ROLES
Route::group(["middleware" => ["auth"]], function(){
    Route::resource('roles', RoleController::class);
});
