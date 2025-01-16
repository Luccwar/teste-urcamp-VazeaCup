@extends('master')

@section('content')

<div class="games-container">
    <h2 class="page-title">Listagem de Partidas</h2>
    <a href="{{ route('games.create') }}" class="create-button">Criar Nova Partida</a>

    @if($games->isEmpty())
        <p>Nenhuma partida encontrada. <a href="{{ route('games.create') }}">Clique aqui</a> para criar uma nova partida.</p>
    @else
        <table class="game-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Time da Casa</th>
                    <th>Time Visitante</th>
                    <th>Vencedor</th>
                    <th>Data e Hora</th>
                    <th>Rodada</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->team1->name }}</td>
                    <td>{{ $game->team2->name }}</td>
                    <td>
                        @if($game->winner === 0)
                            Empate
                        @elseif($game->winner === 1)
                            {{ $game->team1->name }}
                        @elseif($game->winner === 2)
                            {{ $game->team2->name }}
                        @else
                            Não definido
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($game->date_time)->format('d/m/Y H:i') }}</td>
                    <td>@if($game->round === 0)
                            Oitavas de Final
                        @elseif($game->round === 1)
                            Quartas de Final
                        @elseif($game->round === 2)
                            Semifinal
                        @elseif($game->round === 3)
                            Final
                        @endif</td>
                    <td>
                        <a href="{{ route('games.edit', ['game' => $game->id]) }}" class="action-link">Editar</a>
                        <form action="{{ route('games.destroy', ['game' => $game->id]) }}" method="post" class="delete-form">
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
        return confirm("Tem certeza de que quer deletar esta partida?");
    }
</script>

@endsection
