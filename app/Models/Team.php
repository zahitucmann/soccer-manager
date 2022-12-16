<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Player;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function setTeamValue()
    {
        $teamValue = 0;
        $players = $this->players;

        foreach ($players as $player) {
            $teamValue += $player->market_value;
        }
        
        $this->team_value = $teamValue;
    }
}
