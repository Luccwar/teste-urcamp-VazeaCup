<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Processar o login
    public function store(Request $request)
    {
        // Validação dos dados
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentativa de autenticação
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'user' => Auth::user(),
            ], 200);
        }

        return response()->json([
            'message' => 'Email e/ou senha incorretos.',
        ], 401);
    }

    // Logout do usuário
    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalidar a sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout realizado com sucesso!',
        ], 200);
    }
}