<?php

namespace App\Services;

use App\Models\Players;
use App\Models\PlayersCards;
use App\Models\PlayersDuels;

class DuelService
{
    private const MAX_ROUNDS = 5;

    public function __construct(
        private readonly PlayersDuels $playersDuels,
        private readonly NewOpponentService $newOpponentService,
        private readonly PlayerCardsService $playerCardsService,
        private readonly PlayersCards $playersCards,
        private readonly PlayerAdvancementService $playerAdvancementService,
    ) {
    }

    public function startNewForPlayer(Players $player): void
    {
        $activeDuel = $this->getActiveDuel($player->id);
        if ($activeDuel === null) {
            $opponentId = $this->newOpponentService->create($player->level);
            $this->playersDuels->createNew($player->id, $opponentId);
        }
    }

    public function getActiveWithCardsForPlayer(int $playerId): array
    {
        $activeDuel = $this->playersDuels->getLastDuelForPlayer($playerId);
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

    public function playerPlayedCard(int $playerId, int $cardId): void
    {
        $activeDuel = $this->getActiveDuel($playerId);
        if ($activeDuel === null) {
            throw new \InvalidArgumentException('Missing active duel for player');
        }

        $playerCard = $this->playersCards->getCardForPlayer($playerId, $cardId);
        if ($playerCard === null) {
            throw new \InvalidArgumentException('Missing card for player');
        }

        $opponentCard = $this->playersCards->getRandomCardForPlayer($activeDuel->opponent_id);

        $this->updateDuel($activeDuel, $playerCard, $opponentCard);

        if ($activeDuel->finished === 1 && $activeDuel->won === 1) {
            var_dump('player won!');
            $this->playerAdvancementService->playerWonGame($playerId);
        }
    }

    private function getActiveDuel(int $playerId): ?PlayersDuels
    {
        return $this->playersDuels->findActiveForPlayer($playerId);
    }

    private function updateDuel(
        PlayersDuels $activeDuel,
        PlayersCards $playerCard,
        PlayersCards $opponentCard,
    ): void {
        $activeDuel->round++;
        $activeDuel->your_points += $playerCard->power;
        $activeDuel->opponent_points += $opponentCard->power;
        if ($activeDuel->round > self::MAX_ROUNDS) {
            $activeDuel->finished = 1;
            $activeDuel->won = (int) ($activeDuel->player_points > $activeDuel->opponent_points);
        }

        $this->playersDuels->updateDuel($activeDuel);
    }
}
