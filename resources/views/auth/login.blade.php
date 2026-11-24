<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>

<body>
    <h1>Iniciar sesión</h1>

    @if (session('success'))
        <p role="status">
            {{ session('success') }}
        </p>
    @endif

    @if ($errors->any())
        <div role="alert">
            <p>Revisa lo siguiente:</p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.iniciar') }}">
        @csrf

        <p>
            <label for="email">Correo electrónico:</label>
            <br>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="username"
                maxlength="255"
                required
                autofocus
            >
        </p>

        <p>
            <label for="password">Contraseña:</label>
            <br>

            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >
        </p>

        <button type="submit">
            Iniciar sesión
        </button>
    </form>

    <p>
        ¿No tienes cuenta?

        <a href="{{ route('registro') }}">
            Regístrate
        </a>
    </p>
</body>
</html>