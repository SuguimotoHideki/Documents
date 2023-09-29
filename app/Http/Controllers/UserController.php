<?php

namespace App\Http\Controllers;

use App\Rules\Cpf;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Rules\CurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Returns single user
    public function show(User $user)
    {
        return view('auth.show',[
            'user' => $user
        ]);
    }

    //Returns all users
    public function index()
    {
        $users = User::where('id', '!=', 1)
        ->sortable()
        ->paginate(15);
        return view('auth.index',[
            'users' => $users
        ]);
    }

    //Show edit form
    public function edit(User $user)
    {
        $roleList = Role::all();
        return view('auth.edit', [
            'user' => $user,
            'roles' => $roleList
        ]);
    }

    //Show password edit form
    public function editPassword(User $user)
    {
        return view('auth.editPassword', [
            'user' => $user
        ]);
    }

    //Update user data
    public function update(Request $request, User $user)
    {
        $canManageUser = Auth::user()->hasPermissionTo('update any user');

        $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'digits:11', Rule::unique('users', 'cpf')->ignore($user, 'id'), new Cpf],
            'user_email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'user_email')->ignore($user, 'id')],
            'user_institution' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'current_password' => $canManageUser ? [] : ['required', 'string', 'min:3', new CurrentPassword],
            'user_phone_number' => ['required', 'string', 'digits:11', Rule::unique('users', 'user_phone_number')->ignore($user, 'id')],
        ]);

        $user->update($request->except('current_password'));

        return redirect()->route('showUser', $user)->with('success', 'Informações de perfil atualizadas.');
    }

    //Update user password
    public function updatePassword(Request $request, User $user)
    {
        $canManageUser = Auth::user()->hasPermissionTo('update any user');

        $passwordFields = $request->validate([
            'current_password' => $canManageUser ? [] : ['required', 'string', new CurrentPassword],
            'password' => ['required', 'string', 'min:3', 'confirmed', new CurrentPassword]
        ]);

        
        $user->update(['password' => Hash::make($passwordFields['password'])]);

        return redirect()->route('showUser', $user)->with('success', 'Senha atualizada.');
    }
}