<?php

namespace App\Services;

use App\Models\Cards;
use App\Models\PlayersCards;

class RandomCardService
{
    public function __construct(
        private readonly Cards $cards,
        private readonly PlayersCards $playersCards,
    ) {
    }

    public function addForPlayer(int $playerId): void
    {
        $this->playersCards
            ->insert([
                'player_id' => $playerId,
                'card_id' => $this->pickRandomCard()
            ])
        ;
    }

    private function pickRandomCard(): int
    {
        $cards = $this->cards->select()->get();
        $randomCard = rand(0, (count($cards) - 1));

        return $cards[$randomCard]->id;
    }
}
