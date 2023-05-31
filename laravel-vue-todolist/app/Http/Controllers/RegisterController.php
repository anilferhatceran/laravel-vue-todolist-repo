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
        $attributes = request()->validate([
            'name' => ['required', 'max:85'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255']
        ]);

        $attributes['password'] = bcrypt($attributes['password']);


        $user = User::create($attributes);

        $user->save();

        Auth::login($user);

    }
}
