<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // dd($users);
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return redirect()->route('users.index');
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {

        $password = $request->password;



        $password_confirmation = $request->password_confirmation;

        if ($password == $password_confirmation) {
            $userData = $request->except('password', 'password_confirmation');
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($password);
            }
            $user->update($userData);
            return redirect()->route('users.index');
        }

        return redirect()->back()->with(
            'error',
            'Password dan Confirm Password tidak sama'
        );
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
