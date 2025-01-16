<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'team1_id',
        'team2_id',
        'winner', // Tipo Integer onde 0 = Empate | 1 = Time 1 Vence | 2 = Time 2 Vence
        'date_time',
        'round',
    ];

    // Relacionamento com o modelo Team (Time 1)
    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    // Relacionamento com o modelo Team (Time 2)
    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }
}
