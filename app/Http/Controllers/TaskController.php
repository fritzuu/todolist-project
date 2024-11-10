<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inisialisasi query untuk mengambil tugas milik user yang sedang login
        $query = Task::where('user_id', Auth::id());
    
        // Cek apakah ada input pencarian
        if ($request->has('search')) {
            $search = $request->search;
            // Filter tugas berdasarkan judul atau deskripsi yang mengandung kata kunci
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
    
        // Gunakan paginate untuk menampilkan 10 tugas per halaman
        $tasks = $query->paginate(5); // Atur jumlah per halaman sesuai kebutuhan
    
        return view('tasks.index', compact('tasks'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable',
            'priority' => 'required|in:high,medium,low',

            // Add other validations as needed
        ]);

        // Create a new task for the authenticated user
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'user_id' => Auth::id(), // Associate task with the authenticated user
            // Set other fields as necessary
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Ensure the user can only view their own tasks
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
               // Validasi input
               $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'priority' => 'required|in:high,medium,low',
            ]);
    
            // Temukan tugas berdasarkan ID, lalu perbarui
            $task = Task::findOrFail($id);
            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'priority' => $request->priority,
            ]);
    
            // Redirect ke halaman daftar tugas dengan pesan sukses
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $task = Task::findOrFail($id);
          $task->delete();
  
          return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $task = Task::findOrFail($id);
    
        // Toggle status antara 'completed' dan 'pending'
        $task->status = $task->status === 'completed' ? 'pending' : 'completed';
        $task->save();
    
        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
    }
}
