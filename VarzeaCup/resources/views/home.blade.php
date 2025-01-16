@extends('master')

@section('content')

<div class="home-container">
    <h2 class="page-title">Classificação do Campeonato</h2>

    <!-- Formulário para selecionar o ano -->
    @if (!empty($availableYears) && count($availableYears) > 0)
    <form method="GET" action="{{ route('home') }}">
        <label class="form-label" for="year" >Selecione o ano do campeonato:</label>
        <select class="form-input" name="year" id="year" onchange="this.form.submit()">
            @foreach ($availableYears as $yearOption)
                <option value="{{ $yearOption }}" {{ $yearOption == $selectedYear ? 'selected' : '' }}>
                    {{ $yearOption }}
                </option>
            @endforeach
        </select>
    </form>
    @endif

    @if(isset($standings) && count($standings) > 0)
        <table class="home-table">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Time</th>
                    <th>Pontos</th>
                    <th>Jogos</th>
                    <th>Vitórias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($standings as $index => $team)
                    <tr>
                        <td>{{ $team['rank'] }}º</td>
                        <td>{{ $team['team_name'] }}</td>
                        <td>{{ $team['points'] }}</td>
                        <td>{{ $team['games_played'] }}</td>
                        <td>{{ $team['wins'] }}</td>
                        <td>{{ $team['draws'] }}</td>
                        <td>{{ $team['losses'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="form-message">Não há dados suficientes para exibir a classificação.</p>
    @endif
</div>

@endsection
