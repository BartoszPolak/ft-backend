<?php

namespace App\Services;

use App\Models\Players;

class PlayerAdvancementService
{
    private const WON_PLAY_POINTS = 20;
    private const NEW_CARDS_ON_LEVEL = 5;

    /**
     * @var int[]
     */
    private readonly array $levels;

    public function __construct(private readonly Players $players)
    {
        $this->levels = config('game.player_levels');
    }

    public function playerWonGame(int $playerId): void
    {
        $player = $this->players->find($playerId);
        $player->points += self::WON_PLAY_POINTS;

        $playerNewLevel = $this->getPlayerNewLevel($player);

        if ($playerNewLevel > $player->level) {
            $player->points -= $this->levels[$playerNewLevel];
            $player->level = $playerNewLevel;
            $player->new_cards += self::NEW_CARDS_ON_LEVEL;
        }

        $this->players->savePlayerProgress($player);
    }

    private function getPlayerNewLevel(Players $player): int
    {
        $playerNewLevel = 1;
        foreach($this->levels as $level => $maxPoints) {
            if ($player->points >= $maxPoints) {
                $playerNewLevel = $level;
            }
        }

        return $playerNewLevel;
    }
}
