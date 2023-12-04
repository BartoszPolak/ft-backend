<?php

namespace App\Services;

use App\Models\Players;

class NewOpponentService
{
    public function __construct(
        private readonly Players $players,
        private readonly RandomCardService $randomCardService,
        private readonly PlayerCardsService $playerCardsService,
    ) {
    }

    public function create(int $level): int
    {
        $opponent = $this->players->createOpponentWithLevel($level);
        $opponentCardsIds = $this->randomCardService->pickRandomDeck(rand(5, 15));
        foreach ($opponentCardsIds as $cardsId) {
            $this->playerCardsService->addForPlayer(
                playerId: $opponent->id,
                cardId: $cardsId
            );
        }

        return $opponent->id;
    }
}
