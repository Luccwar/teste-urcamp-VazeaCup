@extends('master')

@section('content')

<div class="users-container">

    <h2 class="page-title">Listagem de Usuários</h2>
    <a href="{{ route('users.create') }}" class="create-button">Criar Novo Usuário</a>

    @if (session()->has('message'))
            <p class="form-message">{{ session()->get('message') }}</p>
    @endif

    @if($users->isEmpty())
        <p>Nenhum usuário encontrado. <a href="{{ route('users.create') }}">Clique aqui</a> para criar um novo usuário.</p>
    @else
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ Str::limit($user->password, 12, '...') }}</td> <!-- Limitar tamanho do hash da senha -->
                    <td>
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="action-link">Editar</a>
                        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link delete-button" onclick="return confirmDeletion();">Deletar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    function confirmDeletion() {
        return confirm("Tem certeza de que quer deletar este usuário?");
    }
</script>

@endsection
