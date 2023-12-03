<?php

namespace App\Http\Controllers;

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
        $playerId = $this->players->findByUserId($request->user()->id);

        $this->playerCardsService->addForPlayer(
            playerId: $playerId,
            cardId: $cardId
        );

        return response()->json([]);
    }
}
