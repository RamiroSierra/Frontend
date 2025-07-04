<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', [TareaController::class, 'listar'])->name('home');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/registrar', function () {return view('auth.registrar', ['loggedIn' => false]);})->name('registrar.form');
Route::post('/registrar', [AuthController::class, 'registrar'])->name('registrar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([AuthMiddleware::class])->group(function () {

    Route::get('/tareas/crear', [TareaController::class, 'formularioCrear'])->name('tareas.crear');
    Route::post('/tareas', [TareaController::class, 'guardar'])->name('tareas.guardar');
    Route::delete('/tareas/{id}', [TareaController::class, 'eliminar'])->name('tareas.eliminar');
    Route::get('/tareas/{id}/editar', [TareaController::class, 'formularioEditar'])->name('tareas.editar');
    Route::put('/tareas/{id}', [TareaController::class, 'actualizar'])->name('tareas.actualizar');
    Route::get('/tareas/{id}/comentar', [TareaController::class, 'formularioComentar'])->name('tareas.comentar');
    Route::post('/tareas/{id}/comentarios', [TareaController::class, 'guardarComentario'])->name('tareas.comentario.guardar');
});

Route::get('/tareas/{id}', [TareaController::class, 'detalles'])->name('tareas.detalles');