<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->authApiUrl = env('AUTH_API_URL', 'http://localhost:8000');
    }

    public function login(Request $request)
    {
        $response = Http::asForm()->post($this->authApiUrl.'/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('access_token', $data['access_token']);
            Session::put('refresh_token', $data['refresh_token']);
            return redirect('/');
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|'
        ]);

        $response = Http::post($this->authApiUrl.'/api/user', $request->only([
            'name', 'email', 'password', 'password_confirmation'
        ]));

        if ($response->successful()) {
            return redirect('/')->with('success', 'Registro exitoso. Por favor inicia sesión.');
        }

        return back()->with('error', 'Error en el registro: ' . $response->body());
    }
}
