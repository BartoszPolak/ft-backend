<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use App\Models\Players;
use App\Services\RandomCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function __construct(
        private readonly Players $players,
        private readonly RandomCardService $randomCardService,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->randomCardService->addForPlayer(
            $this->players->findByUserId(
                $request->user()->id
            )
        );

        return response()->json([]);
    }
}
