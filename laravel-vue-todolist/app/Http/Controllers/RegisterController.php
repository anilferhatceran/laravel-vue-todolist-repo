<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
    }
    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'name' => ['required', 'max:85'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255']
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        $user->save();

        Auth::login($user);
    }
}
