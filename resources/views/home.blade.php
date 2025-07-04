<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Tareas</title>
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
        
        <h2>Crear Nueva Tarea</h2>
        <form method="GET" action="{{ route('tareas.crear') }}">
            <button type="submit">Crear Tarea</button>
        </form>
    @else
        <h2>Iniciar sesión</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <button type="submit">Aceptar</button>
        </form>
        <form method="GET" action="{{ route('registrar.form') }}">
            <button type="submit">Crear una cuenta</button>
        </form>
    @endif

    <h2>Tareas</h2>
    <ul>
        @foreach($tareas as $tarea)
            <li>
                {{ $tarea['titulo'] }}
                <a href="{{ route('tareas.detalles', $tarea['id']) }}">Detalles</a>
                
                @if($loggedIn)
                    <form action="{{ route('tareas.eliminar', $tarea['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Borrar</button>
                    </form>
                    <a href="{{ route('tareas.editar', $tarea['id']) }}">Editar</a>
                    <a href="{{ route('tareas.comentar', $tarea['id']) }}">Comentar</a>
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>