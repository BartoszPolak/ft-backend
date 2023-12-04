<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\PlayedCardRequest;
use App\Models\Players;
use App\Models\PlayersDuels;
use App\Services\DuelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerDuelController extends Controller
{
    public function __construct(
        private readonly Players $players,
        private readonly PlayersDuels $playersDuels,
        private readonly DuelService $duelService,
    ) {
    }

    public function getPastDuels(Request $request): JsonResponse
    {
        $player = $this->players->findByUserId($request->user()->id);
        $duels = $this->playersDuels->findAllFinishedForPlayer($player->id);

        return response()->json($duels);
    }

    public function startNewDuel(Request $request): JsonResponse
    {
        $player = $this->players->findByUserId($request->user()->id);
        $this->duelService->startNewForPlayer($player);

        return response()->json([]);
    }

    public function getActiveDuel(Request $request): JsonResponse
    {
        $player = $this->players->findByUserId($request->user()->id);
        $duel = $this->duelService->getActiveWithCardsForPlayer($player->id);

        return response()->json($duel);
    }

    public function playerPlayedCard(PlayedCardRequest $request): JsonResponse
    {
        $cardId = $request->validated('id');
        $player = $this->players->findByUserId($request->user()->id);

        $this->duelService->playerPlayedCard(
            playerId: $player->id,
            cardId: $cardId
        );

        return response()->json([]);
    }
}
