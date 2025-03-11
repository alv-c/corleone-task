<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class DashboardBoardPage extends Component
{
    public $tasks;

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Task::with('user', 'assignedUser')->orderBy('due_date', 'asc')->get();
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->update(['status' => $newStatus]);
        }

        $this->loadTasks(); // Atualiza as tarefas na tela em tempo real
    }

    public function render()
    {
        return view('livewire.dashboard-board-page');
    }
}
