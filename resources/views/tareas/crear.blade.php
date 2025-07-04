<!DOCTYPE html>
<html>
<head>
    <title>Crear Nueva Tarea</title>
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
    <h1>Crear Nueva Tarea</h1>
    <form method="POST" action="{{ route('tareas.guardar') }}">
        @csrf
        <input type="text" name="titulo" placeholder="Título" required><br>
        <input type="number" name="asignado_id" placeholder="ID del Asignado" required><br>
        <textarea name="cuerpo" placeholder="Descripción" required></textarea><br>
        <input type="date" name="fecha_expiracion" required><br>
        <input type="text" name="categorias" placeholder="Categorías (separadas por coma)"><br>
        <button type="submit">Crear Tarea</button>
    </form>
</body>
</html>