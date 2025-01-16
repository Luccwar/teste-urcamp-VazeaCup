<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
        return response()->json(['data' => $teams], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255|unique:teams,name',
        ]);

        $team = Team::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json([
            'message' => 'Time criado com sucesso!',
            'data' => $team,
        ], 201);
    }

    public function show(Team $team)
    {
        return response()->json(['data' => $team], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['message' => 'Time não encontrado.'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255|unique:teams,name,' . $id,
        ]);

        $team->update([
            'name' => $validatedData['name'],
        ]);

        return response()->json([
            'message' => 'Time atualizado com sucesso!',
            'data' => $team,
        ], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $team = Team::with('games')->find($id);

        if (!$team) {
            return response()->json(['message' => 'Time não encontrado.'], 404);
        }

        $team->games()->delete(); // Exclui as partidas associadas
        $team->delete();

        return response()->json(['message' => 'Time excluído com sucesso.'], 200);
    }
}
