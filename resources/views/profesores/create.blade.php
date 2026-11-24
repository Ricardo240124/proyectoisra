<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar profesor</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
   <nav>
    <h2>Sistema Escolar</h2>

    <p>
        <strong>Usuario:</strong>
        {{ auth()->user()->name }}
    </p>

    <p>
        <strong>Rol:</strong>
        Profesor
    </p>

    <p>
        <a href="{{ route('profesores.index') }}">
            Lista de profesores
        </a>
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Cerrar sesión
        </button>
    </form>
</nav>

    <main class="mx-auto max-w-3xl px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">
                Registrar profesor
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Completa los datos del nuevo profesor.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">Revisa los siguientes datos:</p>

                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('profesores.store') }}"
              class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="nombre" class="mb-2 block text-sm font-medium">
                        Nombre
                    </label>

                    <input type="text" id="nombre" name="nombre"
                           value="{{ old('nombre') }}"
                           maxlength="255" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="apellido" class="mb-2 block text-sm font-medium">
                        Apellido
                    </label>

                    <input type="text" id="apellido" name="apellido"
                           value="{{ old('apellido') }}"
                           maxlength="255" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="sueldo" class="mb-2 block text-sm font-medium">
                        Sueldo
                    </label>

                    <input type="number" id="sueldo" name="sueldo"
                           value="{{ old('sueldo') }}"
                           min="0" max="99999999.99" step="0.01" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="titulo" class="mb-2 block text-sm font-medium">
                        Título
                    </label>

                    <input type="text" id="titulo" name="titulo"
                           value="{{ old('titulo') }}"
                           maxlength="255" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="correo" class="mb-2 block text-sm font-medium">
                        Correo electrónico
                    </label>

                    <input type="email" id="correo" name="correo"
                           value="{{ old('correo') }}"
                           maxlength="255" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="telefono" class="mb-2 block text-sm font-medium">
                        Teléfono
                    </label>

                    <input type="tel" id="telefono" name="telefono"
                           value="{{ old('telefono') }}"
                           maxlength="20" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="activo" class="mb-2 block text-sm font-medium">
                        Activo
                    </label>

                    <select id="activo" name="activo"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:outline-indigo-500">
                        <option value="1"
                            {{ old('activo', '1') == '1' ? 'selected' : '' }}>
                            Sí
                        </option>

                        <option value="0"
                            {{ old('activo', '1') == '0' ? 'selected' : '' }}>
                            No
                        </option>
                    </select>
                </div>

                <div>
                    <label for="horas" class="mb-2 block text-sm font-medium">
                        Horas
                    </label>

                    <input type="number" id="horas" name="horas"
                           value="{{ old('horas') }}"
                           min="0" step="1" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>

                <div>
                    <label for="turno" class="mb-2 block text-sm font-medium">
                        Turno
                    </label>

                    <input type="text" id="turno" name="turno"
                           value="{{ old('turno') }}"
                           maxlength="255" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-indigo-500">
                </div>
            </div>

            <div class="mt-8 flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('profesores.index') }}"
                   class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Registrar profesor
                </button>
            </div>
        </form>
    </main>
</body>
</html>