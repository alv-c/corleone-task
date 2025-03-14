@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Criar Nova Tarefa</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Data de Vencimento</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="inicio">Início</option>
                <option value="em execução">Em Execução</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Criado por</label>
            <select name="user_id" class="form-control">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Atribuir para</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Selecione um responsável --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection