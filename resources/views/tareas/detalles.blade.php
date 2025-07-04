<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Tarea</title>
</head>
<body>
    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if($loggedIn)
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Deslogear</button>
    </form>    
    @endif
    <a href="{{ route('home') }}">inicio</a>

    <h1>{{ $tarea['titulo'] }}</h1>
    <p><strong>Cuerpo:</strong> {{ $tarea['cuerpo'] }}</p>
    <p><strong>Autor ID:</strong> {{ $tarea['autor_id'] }}</p>
    <p><strong>Asignado ID:</strong> {{ $tarea['asignado_id'] }}</p>
    <p><strong>Fecha Expiración:</strong> {{ $tarea['fecha_expiracion'] }}</p>
    <p><strong>Categorías:</strong> {{ implode(', ', $tarea['categorias']) }}</p>
    
    <h3>Comentarios</h3>
    <ul>
        @foreach($tarea['comentarios'] ?? [] as $comentario)
            <li>{{ $comentario['texto'] }} ({{ $comentario['fecha'] }})</li>
        @endforeach
    </ul>

    @if($loggedIn)
        <form action="{{ route('tareas.eliminar', $tarea['id']) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Borrar</button>
        </form>
        <a href="{{ route('tareas.editar', $tarea['id']) }}">Editar</a>
        <a href="{{ route('tareas.comentar', $tarea['id']) }}">Comentar</a>
    @endif
</body>
</html>