<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view("tasks.index", compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tasks.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:6',
            'body' => 'max:255',
        ]);

        $task = Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', "$task->title is toegevoegd.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view("tasks.show", compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view("tasks.edit", compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'max:255',
            'progress' => 'numeric|min:0|max:100',
        ]);

        $task->title = $request->title;

        if (isset($request->body)) { // if user removed all data from progress input, field is not sent in request
            $task->body = $request->body;
        } else {
            $task->body = "";
        }

        if (isset($request->progress)) { // if user removed all data from progress input, field is not sent in request
            $task->progress = $request->progress;
        } else {
            $task->progress = 0;
        }

        $task->save();

        return redirect()->route('tasks.index')->with('success', "$task->title is aangepast.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', "$task->title is verwijderd.");
    }
}
