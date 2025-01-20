<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ParticipanteController;

//Rutas de inicio de sesion:
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/Inicio', function () {
    return view('home');
})->middleware('auth');

//Ruta para cerrar sesion:

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//Ruta para crear usuario de inicio de sesion
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

//Rutas para ver el perfil de usuario y editarlo.
Route::get('/profile', [UserController::class, 'show'])->name('users.show');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/profile/update', [UserController::class, 'update'])->name('users.update');

//Ruta para llenado de formulario de cursos
Route::get('/curso/paso1', [CursoController::class, 'crearPaso1'])->name('curso.paso1');
Route::post('/curso/paso1', [CursoController::class, 'guardarPaso1'])->name('curso.paso1.guardar');
Route::get('/curso/paso2', [CursoController::class, 'mostrarPaso2'])->name('curso.paso2');
Route::post('/curso/paso2', [CursoController::class, 'guardarPaso2'])->name('curso.paso2.guardar');
Route::get('/curso/paso3', [CursoController::class, 'mostrarPaso3'])->name('curso.paso3');
Route::post('/curso/paso3', [CursoController::class, 'guardarPaso3'])->name('curso.paso3.guardar');
Route::get('/curso/paso4', [CursoController::class, 'mostrarPaso4'])->name('curso.paso4');
Route::post('/curso/paso4', [CursoController::class, 'guardarPaso4'])->name('curso.paso4.guardar');
Route::get('/curso/paso5', [CursoController::class, 'mostrarPaso5'])->name('curso.paso5');
Route::post('/curso/paso5', [CursoController::class, 'guardarPaso5'])->name('curso.paso5.guardar');
Route::get('/curso/paso6', [CursoController::class, 'mostrarPaso6'])->name('curso.paso6');
Route::post('/curso/paso6', [CursoController::class, 'guardarPaso6'])->name('curso.paso6.guardar');
Route::get('/curso/paso7', [CursoController::class, 'mostrarPaso7'])->name('curso.paso7');
Route::post('/curso/paso7', [CursoController::class, 'guardarPaso7'])->name('curso.guardar-paso7');

//Vista, modificacion, "eliminacion" y consulta de los cursos
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::resource('cursos', CursoController::class);

//Llenado del formulario de los cursos
Route::get('/participantes/crear', [ParticipanteController::class, 'create'])->name('participantes.create');
Route::post('/participantes', [ParticipanteController::class, 'store'])->name('participantes.store');

//Vista, modificacion, "eliminacion" y consulta de los participantes
Route::get('/participantes', [ParticipanteController::class, 'index'])->name('participantes.index');
Route::get('/participantes/create', [ParticipanteController::class, 'create'])->name('participantes.create');
Route::post('/participantes', [ParticipanteController::class, 'store'])->name('participantes.store');

// Ruta para mostrar el formulario de edición
Route::get('/participantes/{N}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');

// Ruta para actualizar los datos del participante
Route::put('/participantes/{N}', [ParticipanteController::class, 'update'])->name('participantes.update');

//Ruta para eliminar participantes
Route::delete('/participantes/{N}', [ParticipanteController::class, 'destroy'])->name('participantes.destroy');
