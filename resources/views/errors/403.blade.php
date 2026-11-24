<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso denegado</title>
</head>

<body>
    <h1>403 - Acceso denegado</h1>

    <p>
        Tu cuenta no tiene permiso para entrar a esta página.
    </p>

    @auth
        @if (in_array(auth()->user()->rol, ['alumno', 'profesor'], true))
            <p>
                <a href="{{ route('dashboard') }}">
                    Volver a mi inicio
                </a>
            </p>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                Cerrar sesión
            </button>
        </form>
    @else
        <p>
            <a href="{{ route('login') }}">
                Iniciar sesión
            </a>
        </p>
    @endauth
</body>
</html>