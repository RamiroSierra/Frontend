<!DOCTYPE html>
<html>
<head>
    <title>Registrar Usuario</title>
</head>
<body>
    <h2>Registrar Usuario</h2>
    <form method="POST" action="{{ route('registrar') }}">
        @csrf
        <input type="text" name="name" placeholder="Nombre" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required><br>
        <button type="submit">Registrar</button>
    </form>
    <a href="{{ route('home') }}">Volver atrás</a>
</body>
</html>