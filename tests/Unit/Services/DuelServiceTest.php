<?php

namespace Services;

use App\Models\Players;
use App\Services\DuelService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DuelServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $player = Players::factory()->make(['id' => 123]);

        $duelServiceMock = $this->partialMock(DuelService::class, function ($mock) {
            $mock->shouldReceive('getActiveDuel')->once()->andReturn(null);
        });

        $duelServiceMock->startNewForPlayer($player);
        $activeDuel = $duelServiceMock->getActiveWithCardsForPlayer($player->id);

        $this->assertSame(0, $activeDuel->finished);
        $this->assertSame(0, $activeDuel->won);
        $this->assertSame(1, $activeDuel->round);
    }
}
