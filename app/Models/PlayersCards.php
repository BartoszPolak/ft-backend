<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayersCards extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getCardForPlayer(int $playerId, int $cardId): PlayersCards
    {
        return $this->newModelQuery()
            ->select('cards.*')
            ->join('cards', 'cards.id', '=', 'players_cards.card_id')
            ->where('players_cards.player_id', '=', $playerId)
            ->where('players_cards.card_id', '=', $cardId)
            ->first()
        ;
    }

    public function getRandomCardForPlayer(int $playerId): PlayersCards
    {
        return $this->newModelQuery()
            ->select('cards.*')
            ->join('cards', 'cards.id', '=', 'players_cards.card_id')
            ->where('players_cards.player_id', '=', $playerId)
            ->orderByRaw('RANDOM()')
            ->first()
        ;
    }
}
