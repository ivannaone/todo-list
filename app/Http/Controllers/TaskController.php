<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

/**
 * TaskController
 *
 * Menangani semua operasi CRUD untuk tugas (Task),
 * termasuk halaman dashboard, statistik, deadline, dan pengaturan.
 */
class TaskController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan ringkasan tugas terbaru.
     */
    public function dashboard()
    {
        $tasks = Task::latest()->get();
        return view('tasks.dashboard', compact('tasks'));
    }

    /**
     * Tampilkan daftar tugas yang melewati deadline dan belum selesai.
     */
    public function deadline()
    {
        $today = date('Y-m-d');
        $tasks = Task::where('deadline', '<', $today)
                ->where('is_done', false)
                ->orderBy('deadline', 'asc')
                ->get();
        return view('tasks.deadline', compact('tasks'));
    }

    /**
     * Tampilkan halaman statistik dengan semua data tugas untuk chart.
     */
    public function statistics()
    {
        $tasks = Task::all();
        return view('tasks.statistics', compact('tasks'));
    }

    /**
     * Tampilkan halaman pengaturan profil dan tema.
     */
    public function settings()
    {
        return view('tasks.settings');
    }

    /**
     * Simpan pengaturan pengguna (username, email, tema) ke session.
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'username' => 'required|min:2|max:50',
            'email'    => 'nullable|email',
        ]);

        session([
            'username' => $request->username,
            'email'    => $request->email,
            'theme'    => $request->theme,
        ]);

        return redirect('/settings')->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Tampilkan daftar semua tugas dengan dukungan filter dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Task::latest();

        // Filter pencarian berdasarkan judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status tugas
        if ($request->filled('filter')) {
            $today = date('Y-m-d');
            if ($request->filter === 'done') {
                $query->where('is_done', true);
            } elseif ($request->filter === 'pending') {
                $query->where('is_done', false)->where(function($q) use ($today) {
                    $q->whereNull('deadline')->orWhere('deadline', '>=', $today);
                });
            } elseif ($request->filter === 'late') {
                $query->where('is_done', false)->where('deadline', '<', $today);
            }
        }

        // Filter berdasarkan prioritas
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Tampilkan form untuk membuat tugas baru.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Simpan tugas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|min:3|max:100',
            'description' => 'nullable|max:500',
            'deadline'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
        ]);

        Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'deadline'    => $request->deadline,
            'priority'    => $request->priority,
            'is_done'     => false,
        ]);

        return redirect('/tasks')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit untuk tugas yang dipilih.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Perbarui data tugas yang sudah ada.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|min:3|max:100',
            'description' => 'nullable|max:500',
            'deadline'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'deadline'    => $request->deadline,
            'priority'    => $request->priority,
            'is_done'     => $request->has('is_done'),
        ]);

        return redirect('/tasks')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Hapus tugas dari database.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks')->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Toggle status selesai/belum selesai pada tugas.
     */
    public function toggleDone(Task $task)
    {
        $task->update(['is_done' => !$task->is_done]);
        $msg = $task->is_done ? 'Tugas ditandai selesai!' : 'Tugas dibuka kembali!';
        return redirect()->back()->with('success', $msg);
    }
}
