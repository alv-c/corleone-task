<div class="container">
    <h2 class="mb-4">Minhas Tarefas</h2>

    {{-- Campo de busca com botão Filtrar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Criar Nova Tarefa</a>

        <div class="d-flex gap-2" style="width: 300px;">
            <input type="text" wire:model="search" placeholder="Buscar tarefa..." class="form-control">
            <button wire:click="filterTasks" class="btn btn-secondary">Filtrar</button>

            @if (!empty($search))
                <button wire:click="clearFilter" class="btn btn-outline-danger">Limpar</button>
            @endif
        </div>
    </div>

    {{-- Kanban Board --}}
    <div
        x-data
        @task-moved.window="$wire.updateTaskStatus($event.detail.taskId, $event.detail.newStatus)"
        class="d-flex justify-content-around flex-wrap gap-3">

        @foreach (['inicio' => 'Início', 'em execução' => 'Em Execução', 'finalizado' => 'Finalizado'] as $status => $label)
        <div class="card w-30 p-2">
            <h4 class="text-center">{{ $label }}</h4>
            <div class="task-column bg-light p-2" ondrop="drop(event, '{{ $status }}')" ondragover="allowDrop(event)">
                @foreach ($tasks->where('status', $status) as $task)
                <div class="task-card p-2 bg-white m-2 border rounded" draggable="true" ondragstart="drag(event, '{{ $task->id }}')">
                    <strong>{{ $task->title }}</strong>
                    <p>{{ $task->description }}</p>
                    @if ($task->assignedUser)
                    <small>Atribuído a: {{ $task->assignedUser->name }}</small>
                    @endif
                </div>
                @endforeach
                @if ($tasks->where('status', $status)->isEmpty())
                <p class="text-muted text-center">Sem tarefas</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.allowDrop = function(event) {
            event.preventDefault();
        }

        window.drag = function(event, taskId) {
            event.dataTransfer.setData("taskId", taskId);
        }

        window.drop = function(event, newStatus) {
            event.preventDefault();
            let taskId = event.dataTransfer.getData("taskId");

            window.dispatchEvent(new CustomEvent('task-moved', {
                detail: {
                    taskId,
                    newStatus
                }
            }));
        }
    });
</script>