<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio del alumno</title>
</head>

<body>
    <header>
        <h1>Sistema Escolar</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                Cerrar sesión
            </button>
        </form>
    </header>

    <hr>

    <main>
        @if (session('success'))
            <p role="status">
                {{ session('success') }}
            </p>
        @endif

        <h2>
            Bienvenido, {{ auth()->user()->name }}
        </h2>

        <p>Esta es tu página de inicio como alumno.</p>

        <p>
            <strong>Nombre:</strong>
            {{ auth()->user()->name }}
        </p>

        <p>
            <strong>Correo electrónico:</strong>
            {{ auth()->user()->email }}
        </p>

        <p>
            <strong>Rol:</strong>
            {{ auth()->user()->rol }}
        </p>
    </main>
</body>
</html>