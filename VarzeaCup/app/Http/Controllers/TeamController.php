<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public readonly Team $team;

    public function __construct()
    {
        $this->team = new Team();
    }

    public function index()
    {
        $teams = $this->team->all();
        return view('teams', ['teams' => $teams]);
    }

    public function create()
    {
        return view('team_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:teams,name',
        ], [
            'name.unique' => redirect()->back()->with('message', 'Este time já existe.'),
        ]);
    
        // Criar o time com os valores padrão
        $created = Team::create([
            'name' => $request->name,
        ]);
    
        if($created)
        {
            return redirect()->back()->with('message', 'Time criado com sucesso!');
        }

        return redirect()->back()->with('message', 'Erro ao criar time.');
    }

    public function show(Team $team)
    {
        return view('team_show', ['team' => $team]);
    }

    public function edit(Team $team)
    {
        return view('team_edit', ['team' => $team]);
    }

    public function update(Request $request, string $id)
    {
        $team = Team::find($id);

        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255|unique:teams,name,' . $id,
            // LEMBRETE: Outros campos como position, points, matches_played, wins, draws, defeats são manipulados automaticamente
        ], [
            'name.unique' => redirect()->back()->with('message', 'Este time já existe.'),
        ]);
    
        // Atualizando o nome do time
        $updated = $team->update([
            'name' => $validatedData['name'],
        ]);

        if ($updated) {
            return redirect()->back()->with('message', 'Time atualizado com sucesso!');
        }

        return redirect()->back()->with('message', 'Erro ao atualizar time.');
    }

    public function destroy(string $id)
    {
        $team = Team::with('games')->find($id);

        if ($team) {
            $team->games()->delete(); // Exclui apenas as partidas associadas ao time
        }

        $team->where('id', $id)->delete();

        return redirect()->route('teams.index');
    }
}
