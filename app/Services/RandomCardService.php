<?php

namespace App\Services;

use App\Models\Cards;
use App\Models\PlayersCards;

class RandomCardService
{
    public function __construct(
        private readonly Cards $cards,
    ) {
    }

    public function pickRandomCard(): int
    {
        $cards = $this->cards->select()->get();
        $randomCard = rand(0, (count($cards) - 1));

        return $cards[$randomCard]->id;
    }
}
