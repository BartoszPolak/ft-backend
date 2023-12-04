<?php

namespace App\Services;

use App\Models\Players;
use App\Models\PlayersDuels;

class DuelService
{
    public function __construct(
        private readonly PlayersDuels $playersDuels,
        private readonly NewOpponentService $newOpponentService,
        private readonly PlayerCardsService $playerCardsService,
    ) {
    }

    public function startNewForPlayer(Players $player): void
    {
        $activeDuel = $this->playersDuels->findActiveForPlayer($player->id);
        if (!$activeDuel) {
            $opponentId = $this->newOpponentService->create($player->level);
            $this->playersDuels->createNew($player->id, $opponentId);
        }
    }

    public function getActiveWithCardsForPlayer(int $playerId): array
    {
        $activeDuel = $this->playersDuels->findActiveForPlayer($playerId);
        if ($activeDuel === null) {
            throw new \InvalidArgumentException('Missing active duel for player');
        }

        $playerCards = $this->playerCardsService->getAllForPlayer($playerId);

        $duel = $activeDuel->toArray();
        $duel['cards'] = [];
        foreach ($playerCards as $card) {
            $duel['cards'][] = $card;
        }

        return $duel;
    }
}
