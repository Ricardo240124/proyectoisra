<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesorController;
use App\Http\Middleware\VerificarRol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function (): RedirectResponse {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get("/users", function(){
    return Auth::user();
});

Route::middleware('guest')->group(function (): void {

   
    Route::get('/login', [AuthController::class, 'verLogin'])
        ->name('login');

    
    Route::post('/login', [AuthController::class, 'iniciar'])
        ->middleware('throttle:6,1')
        ->name('login.iniciar');

    
    Route::get('/registro', [AuthController::class, 'verRegistro'])
        ->name('registro');

  
    Route::post('/registro', [AuthController::class, 'registrar'])
        ->middleware('throttle:6,1')
        ->name('registro.guardar');
});




Route::middleware('auth')->group(function (): void {

    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard');

    Route::view('/alumno', 'welcome')
        ->middleware(VerificarRol::class . ':alumno')
        ->name('alumno');

   
    Route::middleware(VerificarRol::class . ':profesor')
        ->group(function (): void {

           
            Route::get('/profesor', function (): RedirectResponse {
                return redirect()->route('profesores.index');
            })->name('profesor');

           
            Route::get('/profesores/create', [ProfesorController::class, 'create'])
                ->name('profesores.create');

          
            Route::post('/profesores', [ProfesorController::class, 'store'])
                ->name('profesores.store');

           
            Route::get('/profesores', [ProfesorController::class, 'index'])
                ->name('profesores.index');

            Route::get('/profesores/{profesor}/edit', [ProfesorController::class, 'edit'])
                ->name('profesores.edit');

          
            Route::put('/profesores/{profesor}', [ProfesorController::class, 'update'])
                ->name('profesores.update');

            
            Route::delete('/profesores/{profesor}', [ProfesorController::class, 'destroy'])
                ->name('profesores.destroy');
        });

    
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])
        ->name('logout');
});