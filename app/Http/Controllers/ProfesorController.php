<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesor;
use Illuminate\Validation\Rule;


class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    $profesores = Profesor::orderBy('apellido')->get();

    return view('profesores.index', ['profesores' => $profesores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('profesores.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
        'nombre'   => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'sueldo'   => 'required|numeric|between:0,99999999.99|decimal:0,2',
        'titulo'   => 'required|string|max:255',
        'correo'   => 'required|email|max:255|unique:profesores,correo',
        'telefono' => 'required|string|max:20',
        'activo'   => 'required|boolean',
        'horas'    => 'required|integer|min:0|max:4294967295',
        'turno'    => 'required|string|max:255',
    ]);

    Profesor::create($datos);

    return redirect()->route('profesores.create')
        ->with('success', 'Profesor registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profesor $profesor)
    {
        return view('profesores.edit', ['profesor' => $profesor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profesor $profesor)
    {
         $datos = $request->validate([
        'nombre'   => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'sueldo'   => 'required|numeric|between:0,99999999.99|decimal:0,2',
        'titulo'   => 'required|string|max:255',
        'correo'   => [
            'required',
            'email',
            'max:255',
            Rule::unique('profesores', 'correo')->ignore($profesor),
        ],
        'telefono' => 'required|string|max:20',
        'activo'   => 'required|boolean',
        'horas'    => 'required|integer|min:0|max:4294967295',
        'turno'    => 'required|string|max:255',
    ]);

    $profesor->update($datos);

    return redirect()->route('profesores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profesor $profesor)
    {
          $profesor->delete();

    return redirect()->route('profesores.index')
        ->with('success', 'Profesor eliminado correctamente.');
    }
}
