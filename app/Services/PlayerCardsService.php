<?php

namespace App\Services;

use App\Models\Cards;
use App\Models\PlayersCards;

class PlayerCardsService
{
    public function __construct(
        private readonly PlayersCards $playersCards,
        private readonly Cards $cards,
    ) {
    }

    public function getAllForPlayer(int $playerId): array
    {
        $playerCardsIds = $this->playersCards
            ->newModelQuery()
            ->select('card_id')
            ->where('player_id', '=', $playerId)
            ->get()
        ;

        $playerCardsData = $this->cards
            ->newModelQuery()
            ->select('*')
            ->whereIn('id', $playerCardsIds)
            ->get()
        ;

        $playerCards = [];
        foreach ($playerCardsIds as $cardId) {
            $playerCards[] = $playerCardsData->find($cardId['card_id']);
        }

        return $playerCards;
    }

    public function addForPlayer(
        int $playerId,
        int $cardId,
    ): void
    {
        $this->playersCards
            ->newModelQuery()
            ->insert([
                'player_id' => $playerId,
                'card_id' => $cardId
            ])
        ;
    }
}
