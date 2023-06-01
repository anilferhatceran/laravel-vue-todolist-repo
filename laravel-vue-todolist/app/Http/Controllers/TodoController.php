<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    // Index lists a resource
    public function index()
    {
        return Todo::where('user_id', Auth::user()->id)->get();
    }

    // create is for showing a POST form
    public function create()
    {
    }

    // Store(create) a new resource
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:45',
            'description' => 'required|max:255',
            'due_date' => 'required',
            'complete' => 'required'
        ]);

        $attributes['user_id'] = auth()->id();

        return Todo::create($attributes);
    }

    // Display a specific resource
    public function show(Todo $todo)
    {
        return $todo;
    }

    // edit displays the edit form
    public function edit(Todo $todo)
    {
    }

    public function update(Request $request, Todo $todo)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:45',
            'description' => 'required|max:255',
            'due_date' => 'required',
            'complete' => 'required'
        ]);

        $attributes['user_id'] = auth()->id();

        $todo->update($attributes);

        return $todo;
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully. ']);
    }
}
