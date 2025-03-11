@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard Geral de Tarefas</h2>

    <div class="row">
        @foreach (['inicio' => 'Início', 'em execução' => 'Em Execução', 'finalizado' => 'Finalizado'] as $status => $label)
        <div class="col-md-4">
            <h3>{{ $label }}</h3>
            <ul class="list-group">
                @foreach ($tasks->where('status', $status) as $task)
                <li class="list-group-item">
                    <strong>{{ $task->title }}</strong><br>
                    <small>Responsável: {{ $task->assignedUser->name ?? 'Sem atribuição' }}</small><br>
                    <small>Criado por: {{ $task->user->name }}</small><br>
                    <small>Prazo: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sem prazo' }}</small>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</div>
@endsection