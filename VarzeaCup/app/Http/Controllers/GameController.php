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
        return view('games', ['games' => $games]);
    }

    // Mostrar formulário de criação de partida
    public function create()
    {
        // Carregar os times disponíveis
        $teams = Team::all();

        if ($teams->count() < 2) {
            return view('game_create');
        }
    

        // Retornar a view com os times
        return view('game_create', ['teams' => $teams]);
    }

    // Armazenar uma nova partida
    public function store(Request $request)
    {
        $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id|different:team1_id',
            'winner' => 'nullable|integer|in:0,1,2',
            'date_time' => 'required|date',
            'round' => 'required|integer|in:0,1,2,3',
        ]);

        $created = $this->game->create([
            'team1_id' => $request->input('team1_id'),
            'team2_id' => $request->input('team2_id'),
            'winner' => $request->input('winner'),
            'date_time' => $request->input('date_time'),
            'round' => $request->input('round'),
        ]);

        if ($created) {
            return redirect()->back()->with('message', 'Partida criada com sucesso!');
        }

        return redirect()->back()->with('message', 'Erro ao criar partida.');
    }

    // Exibir uma partida específica
    public function show(Game $game)
    {
        return view('game_show', ['game' => $game]);
    }

    // Mostrar formulário de edição de partida
    public function edit(Game $game)
    {
        $teams = Team::all();

        if ($teams->count() < 2) {
            return view('game_edit');
        }

        return view('game_edit', ['game' => $game, 'teams' => $teams]);
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

        $updated = $this->game->where('id', $id)->update([
            'team1_id' => $validatedData['team1_id'],
            'team2_id' => $validatedData['team2_id'],
            'winner' => $validatedData['winner'],
            'date_time' => $validatedData['date_time'],
            'round' => $validatedData['round'],
        ]);

        if ($updated) {
            return redirect()->back()->with('message', 'Partida atualizada com sucesso!');
        }

        return redirect()->back()->with('message', 'Erro ao atualizar partida.');
    }

    // Excluir uma partida
    public function destroy(string $id)
    {
        $this->game->where('id', $id)->delete();

        return redirect()->route('games.index');
    }
}
