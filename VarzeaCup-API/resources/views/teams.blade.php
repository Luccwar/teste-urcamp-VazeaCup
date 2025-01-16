@extends('master')

@section('content')

<div class="teams-container">
    <h2 class="page-title">Listagem de Times</h2>
    <a href="{{ route('teams.create') }}" class="create-button">Criar Novo Time</a>

    @if($teams->isEmpty())
        <p>Nenhum time encontrado. <a href="{{ route('teams.create') }}">Clique aqui</a> para criar um novo time.</p>
    @else
        <table class="team-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                <tr>
                    <td>{{ $team->id }}</td>
                    <td>{{ $team->name }}</td>
                    <td>
                        <a href="{{ route('teams.edit', ['team' => $team->id]) }}" class="action-link">Editar</a>
                        <form action="{{ route('teams.destroy', ['team' => $team->id]) }}" method="post" class="delete-form">
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
        return confirm("Se este time tiver partidas associadas a ele, elas também serão excluídas. Tem certeza de que quer fazer isso?");
    }
</script>

@endsection
