<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
