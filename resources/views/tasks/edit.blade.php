@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Tarefa</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="3">{{ $task->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Data de Vencimento</label>
            <input type="date" name="due_date" class="form-control" value="{{ $task->due_date }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="inicio" {{ $task->status == 'inicio' ? 'selected' : '' }}>Início</option>
                <option value="em execução" {{ $task->status == 'em execução' ? 'selected' : '' }}>Em Execução</option>
                <option value="finalizado" {{ $task->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Criado por</label>
            <select name="user_id" class="form-control" disabled>
                <option value="{{ $task->user_id }}" selected>{{ $task->user->name }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Atribuir para</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Selecione um responsável --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection