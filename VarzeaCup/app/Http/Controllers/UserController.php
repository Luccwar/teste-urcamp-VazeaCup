<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public readonly User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    
    public function index()
    {
        $users = $this->user->all();
        return view('users', ['users' => $users]);
    }

    
    public function create()
    {
        return view('user_create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => redirect()->back()->with('message', 'Este e-mail já está associado a outra conta.'),
        ]);

        $created = $this->user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash de senha
        ]);
    
        if ($created) {
            return redirect()->back()->with('message', 'Criado com sucesso!');
        }
    
        return redirect()->back()->with('message', 'Erro ao criar usuário');
    }

    
    public function show(User $user)
    {
        return view('user_show', ['user' => $user]);
    }

    
    public function edit(User $user)
    {
        return view('user_edit', ['user'=>$user]);
    }

    
    public function update(Request $request, string $id)
    {
        // Validação dos campos (senha obrigatória)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // O " . $id" é utilizado para garantir que o e-mail seja único no banco de dados, mas excluindo o usuário atual durante a validação
            'password' => 'required|min:6',
        ], [
            'email.unique' => redirect()->back()->with('message', 'Este e-mail já está associado a outra conta.'),
        ]);

        // Atualizar o usuário com os dados validados
        $updated = $this->user->where('id', $id)->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash da senha
        ]);

        if ($updated) {
            return redirect()->back()->with('message', 'Atualizado com sucesso!');
        }

        return redirect()->back()->with('message', 'Erro ao atualizar');
    }

    
    public function destroy(string $id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('users.index')->with('message', 'Você não pode excluir a conta que está logada no sistema.');
        }

        $this->user->where('id', $id)->delete();

        return redirect()->route('users.index');
    }
}
