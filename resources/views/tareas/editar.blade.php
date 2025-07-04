<!DOCTYPE html>
<html>
<head>
    <title>Editar Tarea</title>
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
    <h1>Editar Tarea: {{ $tarea['titulo'] }}</h1>
    <form method="POST" action="{{ route('tareas.actualizar', $tarea['id']) }}">
        @csrf
        @method('PUT')
        <input type="text" name="titulo" value="{{ $tarea['titulo'] }}" required><br>
        <input type="number" name="asignado_id" value="{{ $tarea['asignado_id'] }}" required><br>
        <textarea name="cuerpo" required>{{ $tarea['cuerpo'] }}</textarea><br>
        <input type="date" name="fecha_expiracion" value="{{ $tarea['fecha_expiracion'] }}" required><br>
        <input type="text" name="categorias" value="{{ implode(',', $tarea['categorias']) }}"><br>
        <button type="submit">Actualizar Tarea</button>
    </form>
</body>
</html>