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

    /**
     * @param int $cardsAmount
     * @return int[]
     */
    public function pickRandomDeck(int $cardsAmount): array
    {
        $cardsIds = [];
        for ($i = 0; $i < $cardsAmount; $i++) {
            $cardsIds[] = $this->pickRandomCard();
        }

        return $cardsIds;
    }

    public function pickRandomCard(): int
    {
        $cards = $this->cards->select()->get();
        $randomCard = rand(0, (count($cards) - 1));

        return $cards[$randomCard]->id;
    }
}
