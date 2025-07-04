<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\AuthController;

Route::get('/', [TareaController::class, 'listar'])->name('home');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/registrar', function () {return view('auth.registrar', ['loggedIn' => false]);})->name('registrar.form');
Route::post('/registrar', [AuthController::class, 'registrar'])->name('registrar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/tareas/{id}', [TareaController::class, 'detalles'])->name('tareas.detalles');
