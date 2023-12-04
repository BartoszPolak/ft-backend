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
}
