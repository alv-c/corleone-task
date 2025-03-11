<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskBoardPage extends Component
{
    public $search = '';
    public $tasks = [];

    public function mount()
    {
        $this->reloadTasks();
    }

    public function filterTasks()
    {
        $this->reloadTasks();
    }

    public function reloadTasks()
    {
        $query = Task::orderBy('due_date', 'asc');

        $query->where(function ($q) {
            $q->where('user_id', Auth::id())
                ->orWhere('assigned_to', Auth::id());
        });

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
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
        }
    }

    public function clearFilter()
    {
        $this->search = '';
        $this->reloadTasks();
    }

    public function render()
    {
        return view('livewire.task-board-page', [
            'tasks' => $this->tasks,
        ]);
    }
}
