<!DOCTYPE html>
<html>
<head>
    <title>Agregar Comentario</title>
</head>
<body>
    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Deslogear</button>
    </form>
    <a href="{{ route('home') }}">inicio</a>
    <h1>Agregar Comentario a: {{ $tarea['titulo'] }}</h1>
    <form method="POST" action="{{ route('tareas.comentario.guardar', $tarea['id']) }}">
        @csrf
        <textarea name="texto" placeholder="Escribe tu comentario" required></textarea><br>
        <button type="submit">Agregar Comentario</button>
    </form>
</body>
</html>