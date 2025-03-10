@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Minhas Tarefas</h2>

    {{-- Botões de ação --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Criar Nova Tarefa</a>

        {{-- Componente de Filtro de Tarefas --}}
        <livewire:task-filter />
    </div>

    {{-- Kanban Board com Livewire --}}
    <livewire:kanban-board wire:key="kanban-board" />

</div>
@endsection