<div class="d-flex justify-content-around">
    @foreach (['inicio' => 'Início', 'em execucao' => 'Em Execução', 'finalizado' => 'Finalizado'] as $status => $label)
    <div class="card w-30 p-2">
        <h4 class="text-center">{{ $label }}</h4>
        <div class="task-column bg-light p-2" ondrop="drop(event, '{{ $status }}')" ondragover="allowDrop(event)">
            @foreach ($tasks->where('status', $status) as $task)
            <div class="task-card p-2 bg-white m-2 border" draggable="true" ondragstart="drag(event, '{{ $task->id }}')">
                <strong>{{ $task->title }}</strong>
                <p>{{ $task->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script>
    function allowDrop(event) {
        event.preventDefault();
    }

    function drag(event, taskId) {
        event.dataTransfer.setData("taskId", taskId);
    }

    function drop(event, newStatus) {
        event.preventDefault();
        let taskId = event.dataTransfer.getData("taskId");
        Livewire.emit('updateTaskStatus', taskId, newStatus);
    }
</script>