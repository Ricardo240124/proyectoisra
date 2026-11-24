<?php

namespace App\Http\Controllers;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function verLogin(): View
    {
        return view('auth.login');
    }

    public function verRegistro(): View
    {
        return view('auth.registro');
    }

    public function registrar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
                'confirmed',

                function (string $attribute, mixed $value, Closure $fail): void {
                    if (strlen($value) > 72 || str_contains($value, "\0")) {
                        $fail('La contraseña es demasiado larga o contiene un carácter no válido.');
                    }
                },
            ],

            'rol' => [
                'required',
                Rule::in(['alumno', 'profesor']),
            ],
        ], [
            'name.required' => 'Escribe tu nombre.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',

            'email.required' => 'Escribe tu correo electrónico.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'email.max' => 'El correo no debe superar los 255 caracteres.',
            'email.unique' => 'Ya existe una cuenta con ese correo electrónico.',

            'password.required' => 'Escribe una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            'rol.required' => 'Selecciona alumno o profesor.',
            'rol.in' => 'El rol debe ser alumno o profesor.',
        ]);

        $usuario = new User;
        $usuario->name = $datos['name'];
        $usuario->email = $datos['email'];
        $usuario->password = Hash::make($datos['password']);
        $usuario->rol = $datos['rol'];
        $usuario->save();

        Auth::login($usuario);

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        return redirect()->route('dashboard')
            ->with('success', 'Tu cuenta se creó correctamente.');
    }

    public function iniciar(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],

            'password' => [
                'bail',
                'required',
                'string',

                function (string $attribute, mixed $value, Closure $fail): void {
                    if (strlen($value) > 72 || str_contains($value, "\0")) {
                        $fail('El correo o la contraseña son incorrectos.');
                    }
                },
            ],
        ], [
            'email.required' => 'Escribe tu correo electrónico.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'password.required' => 'Escribe tu contraseña.',
        ]);

        if (! Auth::attempt($credenciales)) {
            return back()
                ->withErrors([
                    'email' => 'El correo o la contraseña son incorrectos.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        return redirect()->route('dashboard');
    }

    public function dashboard(Request $request): RedirectResponse
    {
        $rol = $request->user()->rol;

        if ($rol === 'alumno') {
            return redirect()->route('alumno');
        }

        if ($rol === 'profesor') {
            return redirect()->route('profesor');
        }

        abort(403, 'Tu cuenta no tiene un rol válido.');
    }

    public function cerrarSesion(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Cerraste sesión correctamente.');
    }
}