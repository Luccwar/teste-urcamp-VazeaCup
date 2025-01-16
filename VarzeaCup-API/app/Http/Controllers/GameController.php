<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Team;
use DateTime;

class GameController extends Controller
{
    public readonly Game $game;

    public function __construct()
    {
        $this->game = new Game();
    }

    // Listar todas as partidas
    public function index()
    {
        $games = $this->game->all();
        return response()->json(['games' => $games], 200);
    }

    // Armazenar uma nova partida
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id|different:team1_id',
            'winner' => 'nullable|integer|in:0,1,2',
            'date_time' => 'required|date',
            'round' => 'required|integer|in:0,1,2,3',
        ]);

        $game = $this->game->create([
            'team1_id' => $validatedData['team1_id'],
            'team2_id' => $validatedData['team2_id'],
            'winner' => $validatedData['winner'],
            'date_time' => $validatedData['date_time'],
            'round' => $validatedData['round'],
        ]);

        return response()->json(['message' => 'Partida criada com sucesso!', 'game' => $game], 201);
    }

    // Exibir uma partida específica
    public function show(Game $game)
    {
        return response()->json(['game' => $game], 200);
    }

    // Atualizar uma partida existente
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id|different:team1_id',
            'winner' => 'nullable|integer|in:0,1,2',
            'date_time' => 'required|date',
            'round' => 'required|integer|in:0,1,2,3',
        ]);

        $dateTime = new DateTime($validatedData['date_time']);
        $currentDateTime = new DateTime();

        if ($dateTime > $currentDateTime) {
            $validatedData['winner'] = null; // Limpa o vencedor para datas futuras
        }

        $game = $this->game->find($id);

        if (!$game) {
            return response()->json(['message' => 'Partida não encontrada.'], 404);
        }

        $game->update([
            'team1_id' => $validatedData['team1_id'],
            'team2_id' => $validatedData['team2_id'],
            'winner' => $validatedData['winner'],
            'date_time' => $validatedData['date_time'],
            'round' => $validatedData['round'],
        ]);

        return response()->json(['message' => 'Partida atualizada com sucesso!', 'game' => $game], 200);
    }

    // Excluir uma partida
    public function destroy(string $id)
    {
        $game = $this->game->find($id);

        if (!$game) {
            return response()->json(['message' => 'Partida não encontrada.'], 404);
        }

        $game->delete();

        return response()->json(['message' => 'Partida excluída com sucesso.'], 200);
    }
}
