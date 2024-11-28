<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::whereUserId(auth()->id())->get();
        return Inertia::render('Todo',['todos'=>$todos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);
    
        // Create the todo using the validated content and authenticated user
        $todo = new Todo();
        $todo->user_id = auth()->id(); // Use auth()->id() to get the authenticated user's ID
        $todo->content = $validatedData['content']; // Assign the content from the request
        $todo->is_done = false;
        $todo->save();
    
        return redirect('todos');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->is_done = !$todo->is_done;
        $todo->save();
        return redirect('todos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('todos');
    }
}
