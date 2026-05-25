<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function dashboard()
    {
        $tasks = Task::latest()->get();

        return view('tasks.dashboard', compact('tasks'));
    }

    public function deadline()
    {
        $today = date('Y-m-d');

        $tasks = Task::where('deadline', '<', $today)
                ->where('is_done', false)
                ->get();

        return view('tasks.deadline', compact('tasks'));
    }

    public function statistics()
    {
        $tasks = Task::all();

        return view('tasks.statistics', compact('tasks'));
    }

    public function settings()
    {
        return view('tasks.settings');
    }

    public function saveSettings(Request $request)
    {
    session([
        'username' => $request->username,
        'email' => $request->email,
        'theme' => $request->theme,
    ]);

        return redirect('/settings')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function index()
    {
        $tasks = Task::latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Task::create($request->all());

        return redirect('/tasks')
            ->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'is_done' => $request->has('is_done')
        ]);

        return redirect('/tasks')
            ->with('success', 'Tugas berhasil diupdate');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('/tasks')
            ->with('success', 'Tugas berhasil dihapus');
    }

}