<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand mx-3" href="{{ route('tasks.index') }}">Task Manager</a>
    </nav>

    <div class="container mt-3">
        @yield('content')
    </div>
</body>

</html>