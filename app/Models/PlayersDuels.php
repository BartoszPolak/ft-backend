<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayersDuels extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'player_id',
        'opponent_id',
    ];

    public function findAllFinishedForPlayer(int $playerId): ?Collection
    {
        return $this->newModelQuery()
            ->select([
                'players_duels.id',
                'players_duels.won',
                'player.name as player_name',
                'opponent.name as opponent_name',
            ])
            ->leftJoin('players as player', 'player.id', '=', 'players_duels.player_id')
            ->leftJoin('players as opponent', 'opponent.id', '=', 'players_duels.opponent_id')
            ->where('players_duels.player_id', '=', $playerId)
            ->where('players_duels.finished', '=', 1)
            ->get()
        ;
    }

    public function findActiveForPlayer(int $playerId): ?self
    {
        $duel = $this->newModelQuery()
            ->select([
                'players_duels.round',
                'players_duels.player_points as your_points',
                'players_duels.opponent_points',
                'players_duels.finished as status',
            ])
            ->where('players_duels.player_id', '=', $playerId)
            ->where('players_duels.finished', '=', 0)
            ->first()
        ;

        if ($duel !== null) {
            $duel->status = ($duel->status === 0 ? 'active' : 'finished');
        }

        return $duel;
    }

    public function createNew(int $playerId, int $opponentId): void
    {
        $this
            ->newModelQuery()
            ->insert([
                'player_id' => $playerId,
                'opponent_id' => $opponentId,
            ])
        ;
    }
}
