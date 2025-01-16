<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Team;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        /* Fazendo com SQL */

        // Determinar o ano selecionado ou usar o ano atual como padrão
        $selectedYear = $request->query('year', now()->year);

        // Obter os anos disponíveis no banco de dados
        $availableYears = Game::selectRaw("EXTRACT(YEAR FROM date_time) as year")
        ->where('date_time', '<=', now())
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

        // Garante que o ano selecionado esteja entre os anos disponíveis
        if (!in_array($selectedYear, $availableYears)) {
            // Selecionar o ano mais recente disponível
            $selectedYear = $availableYears[0] ?? null; // Caso não haja anos, será null
        }

        // Buscar os dados do campeonato filtrados pelo ano
        $standings = \DB::select("
            SELECT 
                teams.id AS team_id,
                teams.name AS team_name,
                COUNT(games.id) AS games_played,
                SUM(CASE WHEN (games.winner = 1 AND games.team1_id = teams.id) 
                        OR (games.winner = 2 AND games.team2_id = teams.id) THEN 1 ELSE 0 END) AS wins,
                SUM(CASE WHEN games.winner = 0 THEN 1 ELSE 0 END) AS draws,
                SUM(CASE WHEN (games.winner = 2 AND games.team1_id = teams.id) 
                        OR (games.winner = 1 AND games.team2_id = teams.id) THEN 1 ELSE 0 END) AS losses,
                SUM(CASE WHEN (games.winner = 1 AND games.team1_id = teams.id) 
                        OR (games.winner = 2 AND games.team2_id = teams.id) THEN 3
                        WHEN games.winner = 0 THEN 1 ELSE 0 END) AS points
            FROM teams
            LEFT JOIN games 
                ON (games.team1_id = teams.id OR games.team2_id = teams.id)
            WHERE EXTRACT(YEAR FROM games.date_time) = ? AND games.date_time <= NOW() -- Filtro por ano e apenas jogos realizados
            GROUP BY teams.id, teams.name
            ORDER BY points DESC, games_played DESC, wins DESC, draws DESC, losses ASC
        ", [$selectedYear]);

        $rankedStandings = [];
        $currentRank = 1;
        $previousPoints = null;

        foreach ($standings as $index => $team) {
            if ($previousPoints !== $team->points) {
                $currentRank = $index + 1;  // Adiciona 1 pois o índice começa do 0
            }
            $rankedStandings[] = [
                'rank' => $currentRank,
                'team_id' => $team->team_id,
                'team_name' => $team->team_name,
                'games_played' => $team->games_played,
                'wins' => $team->wins,
                'draws' => $team->draws,
                'losses' => $team->losses,
                'points' => $team->points,
            ];
            $previousPoints = $team->points;
        }

        // Enviar dados para a view
        return response()->json([
            'standings' => $rankedStandings,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear
        ]);
    

    /*     Fazendo sem SQL */
    //     Substituir trecho no arquivo home.blade.php caso faça dessa forma
            // <td>{{ $index + 1 }}</td>
            // <td>{{ $team['team_name'] }}</td>
            // <td>{{ $team['points'] }}</td>
            // <td>{{ $team['games_played'] }}</td>
            // <td>{{ $team['wins'] }}</td>
            // <td>{{ $team['draws'] }}</td>
            // <td>{{ $team['losses'] }}</td>

    //     // Obter todos os times
    // $teams = Team::all();


    // $standings = [];

    // foreach ($teams as $team) {
    //     // Inicializar os dados do time
    //     $standings[$team->id] = [
    //         'team_name' => $team->name,
    //         'points' => 0,
    //         'games_played' => 0,
    //         'wins' => 0,
    //         'draws' => 0,
    //         'losses' => 0,
    //     ];
    // }

    // // Processar apenas as partidas que já ocorreram
    // $games = Game::whereNotNull('winner')
    //     ->where('date_time', '<=', now()) // Considerar apenas partidas já realizadas
    //     ->get();

    //     foreach ($games as $game) {
    //         // Atualizar dados do time atacante
    //         if (isset($standings[$game->team1_id])) {
    //             $standings[$game->team1_id]['games_played']++;

    //             if ($game->winner == 1) {
    //                 $standings[$game->team1_id]['wins']++;
    //                 $standings[$game->team1_id]['points'] += 3;
    //             } elseif ($game->winner == 0) {
    //                 $standings[$game->team1_id]['draws']++;
    //                 $standings[$game->team1_id]['points'] += 1;
    //             } else {
    //                 $standings[$game->team1_id]['losses']++;
    //             }
    //         }

    //             // Atualizar dados do time visitante
    //             if (isset($standings[$game->team2_id])) {
    //                 $standings[$game->team2_id]['games_played']++;

    //                 if ($game->winner == 2) {
    //                     $standings[$game->team2_id]['wins']++;
    //                     $standings[$game->team2_id]['points'] += 3;
    //                 } elseif ($game->winner == 0) {
    //                     $standings[$game->team2_id]['draws']++;
    //                     $standings[$game->team2_id]['points'] += 1;
    //                 } else {
    //                     $standings[$game->team2_id]['losses']++;
    //                 }
    //         }
    //     }

    //     // Ordenar a classificação por pontos (maior para menor)
    //     usort($standings, function ($a, $b) {
    //         return $b['points'] <=> $a['points'] ?: $b['wins'] <=> $a['wins'];
    //     });

    //     // Enviar dados para a view
    //     return view('home', compact('standings'));
    }
}
