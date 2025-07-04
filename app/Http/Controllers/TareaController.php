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

    public function formularioCrear()
    {
        return view('tareas.crear', ['loggedIn' => true]);
    }

    public function guardar(Request $request)
    {
        $token = Session::get('access_token');

        $response = Http::withToken($token)->post($this->tareasApiUrl . '/tareas', [
            'titulo' => $request->titulo,
            'asignado_id' => $request->asignado_id,
            'cuerpo' => $request->cuerpo,
            'fecha_expiracion' => $request->fecha_expiracion,
            'categorias' => $request->categorias
        ]);

        return $response->successful()
            ? redirect('/')
            : back()->with('error', 'Error al crear la tarea');
    }

    public function eliminar($id)
    {
        $token = Session::get('access_token');
        $response = Http::withToken($token)->delete("{$this->tareasApiUrl}/tareas/{$id}");

        return $response->successful()
            ? redirect('/')
            : back()->with('error', 'Error al eliminar la tarea');
    }

    public function formularioEditar($id)
    {
        $response = Http::get("{$this->tareasApiUrl}/tareas/{$id}");

        if (!$response->successful()) {
            return redirect('/')->with('error', 'Tarea no encontrada');
        }

        $tarea = $response->json();
        $tarea['categorias'] = explode(',', $tarea['categorias'] ?? '');

        return view('tareas.editar', [
            'tarea' => $tarea,
            'loggedIn' => true
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $token = Session::get('access_token');

        $response = Http::withToken($token)->put("{$this->tareasApiUrl}/tareas/{$id}", [
            'titulo' => $request->titulo,
            'asignado_id' => $request->asignado_id,
            'cuerpo' => $request->cuerpo,
            'fecha_expiracion' => $request->fecha_expiracion,
            'categorias' => $request->categorias
        ]);

        return $response->successful()
            ? redirect()->route('tareas.detalles', $id)
            : back()->with('error', 'Error al actualizar la tarea');
    }

    public function formularioComentar($id)
    {
        $response = Http::get("{$this->tareasApiUrl}/tareas/{$id}");
        $tarea = $response->successful() ? $response->json() : null;

        return view('tareas.comentar', [
            'tarea' => $tarea,
            'loggedIn' => true
        ]);
    }

    public function guardarComentario(Request $request, $id)
    {
        $token = Session::get('access_token');

        $response = Http::withToken($token)->post("{$this->tareasApiUrl}/tareas/{$id}/comentarios", [
            'texto' => $request->texto
        ]);
        
        return $response->successful()
            ? redirect()->route('tareas.detalles', $id)
            : back()->with('error', 'Error al agregar comentario');
    }

}
