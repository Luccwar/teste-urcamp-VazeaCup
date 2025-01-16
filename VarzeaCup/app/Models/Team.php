<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function games()
    {
        return $this->hasMany(Game::class, 'team1_id')->orWhere('team2_id', $this->id);
    }
}
