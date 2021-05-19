<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $this->authorize('view-users');

        return view('users.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $this->authorize('create-user');

        return view('users.create');
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        // dump(request()->all());
        $this->authorize('store-user');

        request()->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
            'password' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = request('name');
        $user->username = request('username');
        $user->role = request('role');
        $user->password = Hash::make(request('password'));

        // save to databse and redirect
        $user->save();

        return redirect('/users');
    }


    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $this->authorize('edit-user', [$user]);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(User $user)
    {

        $this->authorize('update-user');

        request()->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
            'password' => 'required',
            'password2' => 'required'
        ]);

        $user->name = request('name');
        $user->username = request('username');
        $user->role = request('role');
        $user->password = Hash::make(request('password'));
        $user->save();

        return redirect('/users');
    }

    /**
     * Remove the specified user from database.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete-user');

        $user->delete();
        return redirect('/users');
    }
}
