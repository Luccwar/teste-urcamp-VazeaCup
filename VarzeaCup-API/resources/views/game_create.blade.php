@extends('master')

@section('content')

<div class="form-container">
    <h2 class="form-title">Criar Partida</h2>

    @if (session()->has('message'))
        <p class="form-message">{{ session()->get('message') }}</p>
    @endif

    @if(isset($teams) && $teams->count() > 0)
        <form action="{{ route('games.store') }}" method="post" id="createGameForm" class="game-form" onsubmit="return validateForm()">
            @csrf

            <div class="form-group">
                <label for="team1" class="form-label">Time Atacante:</label>
                <select id="team1" name="team1_id" class="form-input" required>
                    <option value="">Selecione o time atacante</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="team2" class="form-label">Time Visitante:</label>
                <select id="team2" name="team2_id" class="form-input" required>
                    <option value="">Selecione o time visitante</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="winner" class="form-label">Vencedor:</label>
                <select id="winner" name="winner" class="form-input" disabled>
                    <option value="">Selecione um resultado</option>
                    <option value="0">Empate</option>
                    <option id="team1Option" value="1"></option>
                    <option id="team2Option" value="2"></option>
                </select>
                <small class="form-error" id="winner-error"></small>
            </div>

            <div class="form-group">
                <label for="date_time" class="form-label">Data e Hora:</label>
                <input type="datetime-local" id="date_time" name="date_time" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="round" class="form-label">Rodada:</label>
                <select id="round" name="round" class="form-input" required>
                    <option value="">Selecione a rodada</option>
                    <option value="0">Oitavas de final</option>
                    <option value="1">Quartas de final</option>
                    <option value="2">Semifinal</option>
                    <option value="3">Final</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="form-button" id="submitButton">Enviar</button>
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
    const team1Option = document.getElementById('team1Option');
    const team2Option = document.getElementById('team2Option');
    const dateTimeInput = document.getElementById('date_time');
    const submitButton = document.getElementById('submitButton');
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
        if (team1Select.value && team2Select.value && dateTimeInput.value) {
            const selectedDate = new Date(dateTimeInput.value);
            const currentDate = new Date();

            if (selectedDate > currentDate) {
                winnerSelect.disabled = true;
                winnerSelect.value = "";
                winnerError.textContent = "";
            } else {
                winnerSelect.disabled = false;
            }
        } else {
            winnerSelect.disabled = true;
            winnerSelect.value = "";
        }
    }

    dateTimeInput.addEventListener('change', toggleWinnerSelect);
    team1Select.addEventListener('change', toggleWinnerSelect);
    team2Select.addEventListener('change', toggleWinnerSelect);

    function validateForm() {
        let isValid = true;

        // Validar vencedor apenas quando estiver habilitado
        if (!winnerSelect.disabled && winnerSelect.value.trim() === "") {
            winnerError.textContent = "Se a partida já ocorreu, um resultado deve ser selecionado.";
            isValid = false;
        } else {
            winnerError.textContent = "";
        }

        return isValid;
    }

</script>

@endsection
