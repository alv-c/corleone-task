<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskFilter extends Component
{
    public $search = '';

    public function render()
    {
        $tasks = Task::where('title', 'like', "%{$this->search}%")->get();
        return view('livewire.task-filter', compact('tasks'));
    }
}
