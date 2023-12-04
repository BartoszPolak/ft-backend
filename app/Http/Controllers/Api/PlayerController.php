<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Players;
use App\Services\PlayerCardsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct(
        private readonly Players $players,
        private readonly PlayerCardsService $playerCardsService,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        $player = $this->players->findByUserId($user->id);

        $levels = config('game.player_levels');
        $playerLevelMaxPoints = $levels[$player->level];

        return response()->json([
            'id' => $user->id,
            'username' => $user->name,
            'level' => $player->level,
            'level_points' => $player->points . '/' . $playerLevelMaxPoints,
            'cards' => $this->playerCardsService->getAllForPlayer($player->id),
            'new_card_allowed' => (bool) ($player->new_cards > 0),
        ]);
    }
}