<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'level',
        'name',
    ];

    public function getLevelMaxPoints(): int
    {
        $levels = config('game.player_levels');
        $showNextLevelPoints = (($this->level + 1) > end($levels)) ? $this->level : ($this->level + 1);
        return $levels[$showNextLevelPoints];
    }

    public function findByUserId(int $userId): self
    {
        return $this->newModelQuery()
            ->select('*')
            ->where('user_id', '=', $userId)
            ->first()
        ;
    }

    public function createOpponentWithLevel(int $level): self
    {
        return $this
            ->factory()
            ->create([
                'user_id' => null,
                'level' => $level,
                'name' => fake('en_US')->name(),
            ])
        ;
    }

    public function savePlayerProgress(Players $player): void
    {
        $this->newModelQuery()
            ->where('id', '=', $player->id)
            ->update([
                'points' => $player->points,
                'level' => $player->level,
            ])
        ;
    }
}
