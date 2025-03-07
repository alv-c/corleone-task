@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Tarefas</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Nova Tarefa</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Status</th>
                <th>Data de Vencimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ ucfirst($task->status) }}</td>
                <td>{{ $task->due_date ?? 'Sem data' }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection