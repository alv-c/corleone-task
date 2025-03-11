<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskFilter extends Component
{
    public $search = '';

    public function updatedSearch($value)
    {
        $this->dispatch('tasksFiltered', ['search' => $value]);
    }

    public function render()
    {
        return view('livewire.task-filter');
    }

    // public function filterTasks()
    // {
    //     $query = Task::query();

    //     if ($this->onlyMine) {
    //         $query->where(function ($q) {
    //             $q->where('user_id', Auth::id())
    //                 ->orWhere('assigned_to', Auth::id());
    //         });
    //     }

    //     if (!empty($this->search)) {
    //         $query->where('title', 'like', '%' . $this->search . '%');
    //     }

    //     $tasks = $query->orderBy('due_date', 'asc')->get();

    //     $this->dispatch('tasksFiltered', ['search' => $this->search]);
    // }
}
