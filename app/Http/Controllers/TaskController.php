<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $tasks = Task::where('user_id', $userId)
            ->orWhere('assigned_to', $userId)
            ->orderBy('due_date', 'asc')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:inicio,em execução,finalizado',
            'user_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Tarefa atribuída com sucesso!');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:inicio,em execução,finalizado',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa removida!');
    }

    public function dashboard()
    {
        $tasks = Task::with('user', 'assignedUser')->orderBy('due_date', 'asc')->get();
        return view('dashboard', compact('tasks'));
    }
}
