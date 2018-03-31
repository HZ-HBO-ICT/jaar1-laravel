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
        //$tasks = Task::all();
        $tasks = Task::whereNull('parent_id')->get();

        return view("tasks.index", compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function create(Task $task)
    {
        return view("tasks.create", compact('task'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|min:6',
            'hours_planned' => 'numeric|min:0',
            'body' => 'max:255',
            'state' => 'numeric|min:0|max:3'
        ]);

        if ( $task )
        {
            $newTask = $task->children()->create($request->all());
            return redirect()->route('tasks.show', ['task' => $task])->with('success', "$newTask->title is toegevoegd.");
        } else {
            $newTask = Task::create($request->all());
            return redirect()->route('tasks.index')->with('success', "$newTask->title is toegevoegd.");
        }
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
            'state' => 'numeric|min:0|max:3',
            'progress' => 'numeric|min:0|max:100',
            'rating' => 'numeric|min:0|max:5',
        ]);

        $task->title = $request->title;

//            dd($task);
        if (isset($request->state)) { // if user removed all data from progress input, field is not sent in request
            $task->state = $request->state;
        }

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

        if (isset($request->rating)) { // if user removed all data from progress input, field is not sent in request
            $task->rating = $request->rating;
        }

        $task->save();

        $url = $request->previous_url;

        if ($url) {
            return redirect()->to($url)->with('success', "$task->title is aangepast.");
        }

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
