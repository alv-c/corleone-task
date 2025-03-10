<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class KanbanBoard extends Component
{
    public $tasks;
    public $onlyMine = false; // Flag para exibir apenas minhas tarefas ou todas

    protected $listeners = ['taskUpdated' => 'reloadTasks'];

    public function mount($onlyMine = false)
    {
        $this->onlyMine = $onlyMine;
        $this->reloadTasks();
    }

    public function reloadTasks()
    {
        $query = Task::orderBy('due_date', 'asc');

        // Se for página "Minhas Tarefas", filtrar por quem eu criei OU me atribuíram
        if ($this->onlyMine) {
            $query->where(function ($q) {
                $q->where('user_id', Auth::id()) // Tarefas que eu criei
                    ->orWhere('assigned_to', Auth::id()); // Tarefas atribuídas a mim
            });
        }

        $this->tasks = $query->get();
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->update(['status' => $status]);
            $this->reloadTasks();
            $this->emit('taskUpdated');
        }
    }

    public function render()
    {
        return view('livewire.kanban-board', [
            'tasks' => $this->tasks
        ]);
    }
}
