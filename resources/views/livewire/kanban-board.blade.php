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
        </div>
    </div>
    @endforeach
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