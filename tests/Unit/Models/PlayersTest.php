<?php

namespace Models;

use App\Models\Players;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

class PlayersTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @dataProvider getMaxPointsDataProvider
     */
    public function test_getLevelMaxPoints_returnsMaxPoints(int $level, ?int $points): void
    {
        $player = Players::factory()->make(['level' => $level]);
        $this->assertSame($points, $player->getLevelMaxPoints());
    }

    public static function getMaxPointsDataProvider(): array
    {
        return [
            [
                'level' => 1,
                'points' => 100
            ],
            [
                'level' => 2,
                'points' => 160
            ],
            [
                'level' => 3,
                'points' => null
            ],
        ];
    }
}
