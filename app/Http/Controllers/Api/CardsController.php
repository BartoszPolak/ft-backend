<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Players;
use App\Services\PlayerCardsService;
use App\Services\RandomCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function __construct(
        private readonly Players $players,
        private readonly RandomCardService $randomCardService,
        private readonly PlayerCardsService $playerCardsService,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $cardId = $this->randomCardService->pickRandomCard();
        $player = $this->players->findByUserId($request->user()->id);

        $this->playerCardsService->addForPlayer(
            playerId: $player->id,
            cardId: $cardId
        );

        return response()->json([]);
    }
}
