<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskBoardPage extends Component
{
    public $search = ''; // Campo de busca
    public $tasks = []; // Lista de tarefas

    public function mount()
    {
        $this->reloadTasks();
    }

    // Atualiza tarefas quando a busca mudar
    public function updatedSearch()
    {
        $this->reloadTasks();
    }

    // Recarrega tarefas do banco com filtro e "Minhas tarefas"
    public function reloadTasks()
    {
        $query = Task::query()->orderBy('due_date', 'asc');

        // Apenas minhas tarefas
        $query->where(function ($q) {
            $q->where('user_id', Auth::id())
                ->orWhere('assigned_to', Auth::id());
        });

        // Filtro de busca
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $this->tasks = $query->get();
    }

    // Atualização do status via drag and drop
    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->update(['status' => $status]);
            $this->reloadTasks(); // Atualiza o Kanban
        }
    }

    public function render()
    {
        return view('livewire.task-board-page', [
            'tasks' => $this->tasks,
        ]);
    }
}
