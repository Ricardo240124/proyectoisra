<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de profesores</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        [hidden] {
            display: none !important;
        }
    </style>
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

    <main class="mx-auto max-w-screen-2xl space-y-6 px-4 py-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Profesores
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Administración de profesores registrados
                </p>
            </div>

            <a href="{{ route('profesores.create') }}"
               class="rounded-lg bg-indigo-600 px-5 py-2.5 text-center text-sm font-semibold text-white shadow hover:bg-indigo-700">
                + Registrar profesor
            </a>
        </div>

        @if (session('success'))
            <div role="status"
                 class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row">
            <div class="flex-1">
                <label for="buscar" class="sr-only">Buscar profesor</label>

                <input type="search" id="buscar"
                       placeholder="Buscar por ID, nombre, correo o turno..."
                       class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:outline-indigo-500">
            </div>

            <div>
                <label for="estado" class="sr-only">Filtrar por estado</label>

                <select id="estado"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:outline-indigo-500">
                    <option value="todos">Todos los estados</option>
                    <option value="activo">Activos</option>
                    <option value="inactivo">Inactivos</option>
                </select>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4">ID</th>
                            <th class="whitespace-nowrap px-5 py-4">Nombre</th>
                            <th class="whitespace-nowrap px-5 py-4">Apellido</th>
                            <th class="whitespace-nowrap px-5 py-4">Sueldo</th>
                            <th class="whitespace-nowrap px-5 py-4">Título</th>
                            <th class="whitespace-nowrap px-5 py-4">Correo</th>
                            <th class="whitespace-nowrap px-5 py-4">Teléfono</th>
                            <th class="whitespace-nowrap px-5 py-4">Estado</th>
                            <th class="whitespace-nowrap px-5 py-4">Horas</th>
                            <th class="whitespace-nowrap px-5 py-4">Turno</th>
                            <th class="whitespace-nowrap px-5 py-4">Fecha de registro</th>
                            <th class="whitespace-nowrap px-5 py-4">Última actualización</th>
                            <th class="whitespace-nowrap px-5 py-4">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($profesores as $profesor)
                            <tr class="profesor-fila hover:bg-slate-50"
                                data-busqueda="{{ $profesor->id.' '.$profesor->nombre.' '.$profesor->apellido.' '.$profesor->correo.' '.$profesor->turno }}"
                                data-estado="{{ $profesor->activo ? 'activo' : 'inactivo' }}">

                                <td class="px-5 py-4">
                                    {{ $profesor->id }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 font-medium">
                                    {{ $profesor->nombre }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    {{ $profesor->apellido }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    ${{ number_format($profesor->sueldo, 2) }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    {{ $profesor->titulo }}
                                </td>

                                <td class="px-5 py-4">
                                    {{ $profesor->correo }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    {{ $profesor->telefono }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($profesor->activo)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Activo
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    {{ $profesor->horas }}
                                </td>

                                <td class="px-5 py-4">
                                    {{ $profesor->turno }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-slate-500">
                                    {{ $profesor->created_at }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-slate-500">
                                    {{ $profesor->updated_at }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('profesores.edit', $profesor) }}"
                                           class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                            Editar
                                        </a>

                                        <form action="{{ route('profesores.destroy', $profesor) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13"
                                    class="px-5 py-10 text-center text-slate-500">
                                    No hay profesores registrados.
                                </td>
                            </tr>
                        @endforelse

                        <tr id="sinResultados" hidden>
                            <td colspan="13"
                                class="px-5 py-10 text-center text-slate-500">
                                No se encontraron profesores con esos filtros.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 px-5 py-3 text-xs text-slate-500"
                 role="status">
                Profesores mostrados:
                <span id="cantidad">{{ $profesores->count() }}</span>
                de {{ $profesores->count() }} cargados
            </div>
        </div>
    </main>

    <script>
        const buscar = document.getElementById('buscar');
        const estado = document.getElementById('estado');
        const filas = document.querySelectorAll('.profesor-fila');
        const sinResultados = document.getElementById('sinResultados');
        const cantidad = document.getElementById('cantidad');

        function normalizar(texto) {
            return texto
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase();
        }

        function filtrar() {
            const texto = normalizar(buscar.value.trim());
            const estadoSeleccionado = estado.value;

            let visibles = 0;

            filas.forEach(fila => {
                const coincideTexto = normalizar(fila.dataset.busqueda)
                    .includes(texto);

                const coincideEstado =
                    estadoSeleccionado === 'todos' ||
                    fila.dataset.estado === estadoSeleccionado;

                fila.hidden = !(coincideTexto && coincideEstado);

                if (!fila.hidden) {
                    visibles++;
                }
            });

            sinResultados.hidden = filas.length === 0 || visibles > 0;
            cantidad.textContent = visibles;
        }

        buscar.addEventListener('input', filtrar);
        estado.addEventListener('change', filtrar);

        filtrar();
    </script>
</body>
</html>