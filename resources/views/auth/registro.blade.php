<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
</head>

<body>
    <h1>Crear cuenta</h1>

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

    <form method="POST" action="{{ route('registro.guardar') }}">
        @csrf

        <p>
            <label for="name">Nombre completo:</label>
            <br>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                autocomplete="name"
                maxlength="255"
                required
                autofocus
            >
        </p>

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
            >
        </p>

        <p>
            <label for="rol">Rol:</label>
            <br>

            <select id="rol" name="rol" required>
                <option
                    value=""
                    disabled
                    @selected(old('rol', '') === '')
                >
                    Selecciona tu rol
                </option>

                <option
                    value="alumno"
                    @selected(old('rol') === 'alumno')
                >
                    Alumno
                </option>

                <option
                    value="profesor"
                    @selected(old('rol') === 'profesor')
                >
                    Profesor
                </option>
            </select>
        </p>

        <p>
            <label for="password">Contraseña:</label>
            <br>

            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                maxlength="72"
                autocomplete="new-password"
                required
            >
            <br>

            <small>Debe tener al menos 8 caracteres.</small>
        </p>

        <p>
            <label for="password_confirmation">
                Confirmar contraseña:
            </label>
            <br>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                minlength="8"
                maxlength="72"
                autocomplete="new-password"
                required
            >
        </p>

        <button type="submit">
            Crear cuenta
        </button>
    </form>

    <p>
        ¿Ya tienes cuenta?

        <a href="{{ route('login') }}">
            Inicia sesión
        </a>
    </p>
</body>
</html>