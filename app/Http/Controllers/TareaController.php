<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TareaController extends Controller
{
    public function __construct()
    {
        $this->tareasApiUrl = env('TAREAS_API_URL', 'http://localhost:8001/api');
    }

    public function listar()
    {
        $response = Http::get($this->tareasApiUrl . '/tareas');
        $tareas = $response->successful() ? $response->json() : [];

        return view('home', [
            'tareas' => $tareas,
            'loggedIn' => Session::has('access_token')
        ]);
    }

    public function detalles($id)
    {
        $response = Http::get("{$this->tareasApiUrl}/tareas/{$id}");

        $tarea = $response->json();
        $tarea['categorias'] = explode(',', $tarea['categorias'] ?? '');

        return view('tareas.detalles', [
            'tarea' => $tarea,
            'loggedIn' => Session::has('access_token')
        ]);
    }
}
