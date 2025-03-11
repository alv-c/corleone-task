<div class="container">
    <h2 class="mb-4">Painel Geral de Tarefas (Dashboard)</h2>

    {{-- Kanban Board --}}
    <div
        x-data
        @task-moved.window="$wire.updateTaskStatus($event.detail.taskId, $event.detail.newStatus)"
        class="d-flex justify-content-around flex-wrap gap-3">

        @foreach (['inicio' => 'Início', 'em execução' => 'Em Execução', 'finalizado' => 'Finalizado'] as $status => $label)
        <div class="card w-30 p-2">
            <h4 class="text-center">{{ $label }}</h4>
            <div class="task-column bg-light p-2" ondrop="drop(event, '{{ $status }}')" ondragover="allowDrop(event)" style="min-height: 300px;">
                @foreach ($tasks->where('status', $status) as $task)
                <div class="task-card p-2 bg-white m-2 border rounded" draggable="true" ondragstart="drag(event, '{{ $task->id }}')">
                    <strong>{{ $task->title }}</strong>
                    <p>{{ $task->description }}</p>
                    <small><strong>Criado por:</strong> {{ $task->user->name }}</small><br>
                    @if ($task->assignedUser)
                    <small><strong>Atribuído a:</strong> {{ $task->assignedUser->name }}</small><br>
                    @endif
                    <small><strong>Prazo:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sem prazo' }}</small>
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

{{-- Script de Drag and Drop --}}
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

            // Dispara evento para Livewire atualizar o status
            window.dispatchEvent(new CustomEvent('task-moved', {
                detail: {
                    taskId,
                    newStatus
                }
            }));
        }
    });
</script>