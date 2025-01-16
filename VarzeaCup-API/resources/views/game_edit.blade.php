@extends('master')

@section('content')

<div class="form-container">
    <h2 class="form-title">Editar Partida</h2>

    @if (session()->has('message'))
        <p class="form-message">{{ session()->get('message') }}</p>
    @endif

    @if(isset($teams) && $teams->count() > 0)
        <form action="{{ route('games.update', $game->id) }}" method="post" id="editGameForm" class="game-form" onsubmit="return validateForm()">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="team1" class="form-label">Time Atacante:</label>
                <select id="team1" name="team1_id" class="form-input" required>
                    <option value="">Selecione o time atacante</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ $team->id == $game->team1_id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="team2" class="form-label">Time Visitante:</label>
                <select id="team2" name="team2_id" class="form-input" required>
                    <option value="">Selecione o time visitante</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ $team->id == $game->team2_id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="winner" class="form-label">Vencedor:</label>
                <select id="winner" name="winner" class="form-input" disabled>
                    <option value="">Selecione um resultado</option>
                    <option value="0" {{ $game->winner === 0 ? 'selected' : '' }}>Empate</option>
                    <option id="team1Option" value="1" {{ $game->winner === 1 ? 'selected' : '' }}>{{ $game->team1->name }}</option>
                    <option id="team2Option" value="2" {{ $game->winner === 2 ? 'selected' : '' }}>{{ $game->team2->name }}</option>
                </select>
                <small class="form-error" id="winner-error"></small>
            </div>

            <div class="form-group">
                <label for="date_time" class="form-label">Data e Hora:</label>
                <input type="datetime-local" id="date_time" name="date_time" class="form-input" value="{{ $game->date_time }}" required>
            </div>

            <div class="form-group">
                <label for="round" class="form-label">Rodada:</label>
                <select id="round" name="round" class="form-input" required>
                    <option value="0" {{ $game->round === 0 ? 'selected' : '' }}>Oitavas de final</option>
                    <option value="1" {{ $game->round === 1 ? 'selected' : '' }}>Quartas de final</option>
                    <option value="2" {{ $game->round === 2 ? 'selected' : '' }}>Semifinal</option>
                    <option value="3" {{ $game->round === 3 ? 'selected' : '' }}>Final</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="form-button" id="submitButton">Atualizar</button>
                <a href="{{ route('games.index') }}" class="back-button">Voltar</a>
            </div>
        </form>
    @else
        <p class="form-message">O sistema possui menos que dois times cadastrados. <a href="{{ route('teams.create') }}">Clique aqui</a> para criar um novo time.</p>
    @endif
</div>

<script>
    const team1Select = document.getElementById('team1');
    const team2Select = document.getElementById('team2');
    const winnerSelect = document.getElementById('winner');
    const dateTimeInput = document.getElementById('date_time');
    const winnerError = document.getElementById('winner-error');

    function synchronizeSelections() {
        const team1Value = team1Select.value;
        const team2Value = team2Select.value;

        if (team1Value === team2Value) {
            if (team1Select === document.activeElement) {
                team2Select.value = '';
            } else {
                team1Select.value = '';
            }
        }

        team1Option.textContent = team1Value ? team1Select.options[team1Select.selectedIndex].text : 'Time Atacante';
        team2Option.textContent = team2Value ? team2Select.options[team2Select.selectedIndex].text : 'Time Visitante';
    }

    team1Select.addEventListener('change', synchronizeSelections);
    team2Select.addEventListener('change', synchronizeSelections);

    function toggleWinnerSelect() {
        const currentDate = new Date();
        const selectedDate = new Date(dateTimeInput.value);

        if (selectedDate > currentDate) {
            winnerSelect.disabled = true;
            winnerSelect.value = "";
            winnerError.textContent = "";
        } else {
            winnerSelect.disabled = false;
        }
    }

    dateTimeInput.addEventListener('change', toggleWinnerSelect);
    document.addEventListener('DOMContentLoaded', toggleWinnerSelect);

    function validateForm() {
        const currentDate = new Date();
        const selectedDate = new Date(dateTimeInput.value);

        if (!winnerSelect.disabled && winnerSelect.value.trim() === "") {
            winnerError.textContent = "Se a partida já ocorreu, um resultado deve ser selecionado.";
            return false;
        } else if (selectedDate > currentDate && winnerSelect.value !== "") {
            winnerError.textContent = "Não é possível selecionar um resultado para uma partida futura.";
            return false;
        } else {
            winnerError.textContent = "";
        }

        return true;
    }
</script>

@endsection
