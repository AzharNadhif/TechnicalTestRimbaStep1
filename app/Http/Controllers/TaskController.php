<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin: lihat semua task
        if ($user->role === 'admin') {
            return Task::all();
        }

        // Manager: lihat task yang dia buat
        if ($user->role === 'manager') {
            return Task::where('created_by', $user->id)->get();
        }

        // Staff: lihat task yang ditugaskan ke dia
        if ($user->role === 'staff') {
            return Task::where('assigned_to', $user->id)->get();
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        // Cek izin via Gate create-task
        if (!Gate::allows('create-task')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'assigned_to' => 'required|exists:users,id',
        ]);

        // Ambil user yang akan ditugaskan
        $assignedUser = User::find($validated['assigned_to']);

        // Validasi: hanya staff yang boleh ditugaskan
        if (!$assignedUser || $assignedUser->role !== 'staff') {
            return response()->json(['message' => 'Only staff can be assigned tasks.'], 422);
        }

        // Buat task
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'assigned_to' => $assignedUser->id,
            'created_by' => $user->id,
        ]);

        // Optional: log aktivitas jika due_date sudah lewat
        if (now()->gt($task->due_date)) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Created task with past due date',
                'metadata' => json_encode($task->toArray()),
            ]);
        }

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Cek izin update (misalnya pakai policy atau manual)
        if (auth()->user()->id !== $task->created_by && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $task->update($request->only(['title', 'description', 'due_date']));

        return response()->json(['message' => 'Task updated successfully']);
    }

    public function destroy($id)
    {
            $user = auth()->user();
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['message' => 'Tugas tidak ditemukan'], 404);
            }

            // Hanya admin yang boleh menghapus
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            try {
                $task->delete();
                return response()->json(['message' => 'Tugas berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal menghapus tugas'], 500);
            }
    }



}
