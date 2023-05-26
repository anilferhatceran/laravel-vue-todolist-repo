<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    // Index lists a resource
    public function index()
    {
        return Todo::get();
    }

    // create is for showing a POST form
    public function create()
    {

    }

    // Store(create) a new resource
    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'title' => 'required',
           'description' => 'required',
            'due_date' => 'required',
            'complete' => 'required'
        ]);

        return Todo::create($validatedData);
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
        $validatedData = $request->validate([
            'title' => 'required|min:3|max:45',
            'description' => 'required|max:255',
        ]);

        $todo->update($validatedData);

        return $todo;
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully. ']);
    }

}
