<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class KanbanBoard extends Component
{
    public $tasks;

    protected $listeners = ['taskUpdated' => 'reloadTasks'];

    public function mount()
    {
        $this->reloadTasks();
    }

    public function reloadTasks()
    {
        $this->tasks = Task::orderBy('due_date', 'asc')->get();
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->update(['status' => $status]);
            $this->reloadTasks();
        }
    }

    public function render()
    {
        return view('livewire.kanban-board', [
            'tasks' => $this->tasks
        ]);
    }
}
