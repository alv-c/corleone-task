<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class KanbanBoard extends Component
{
    public $tasks = [];
    public $onlyMine = false;

    protected $listeners = [
        'taskUpdated' => 'reloadTasks',
        'tasksFiltered' => 'updateFilteredTasks'
    ];

    public function mount($onlyMine = false)
    {
        $this->onlyMine = $onlyMine;
        $this->reloadTasks();
    }

    public function reloadTasks()
    {
        $query = Task::orderBy('due_date', 'asc');

        if ($this->onlyMine) {
            $query->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('assigned_to', Auth::id());
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
            $this->dispatch('taskUpdated');
        }
    }

    public function updateFilteredTasks($params)
    {
        dd($params);

        $query = Task::query();

        if ($this->onlyMine) {
            $query->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('assigned_to', Auth::id());
            });
        }

        if (!empty($params['search'])) {
            $query->where(function ($q) use ($params) {
                $q->where('title', 'like', '%' . $params['search'] . '%')
                    ->orWhere('description', 'like', '%' . $params['search'] . '%');
            });
        }

        $this->tasks = $query->orderBy('due_date', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.kanban-board', [
            'tasks' => $this->tasks
        ]);
    }
}
