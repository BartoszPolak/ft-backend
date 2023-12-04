<?php

namespace App\Services;

use App\Models\Players;

class PlayerAdvancementService
{
    private const WON_PLAY_POINTS = 20;
    private const NEW_CARDS_ON_LEVEL = 5;

    public function __construct(private readonly Players $players)
    {
    }

    public function playerWonGame(int $playerId): void
    {
        $player = $this->players->find($playerId);
        $levels = config('game.player_levels');

        $player->points += self::WON_PLAY_POINTS;

        $newPlayerLevel = 1;
        foreach($levels as $level => $maxPoints) {
            if ($player->points >= $maxPoints) {
                $newPlayerLevel = $level;
            }
        }

        if ($newPlayerLevel > $player->level) {
            $player->points -= $levels[$newPlayerLevel];
            $player->level = $newPlayerLevel;
            $player->new_cards += self::NEW_CARDS_ON_LEVEL;
        }

        $this->players->savePlayerProgress($player);
    }
}
