<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    public function findByUserId(int $userId): Players
    {
        return $this->newModelQuery()
            ->select('*')
            ->where('user_id', '=', $userId)
            ->first()
        ;
    }
}
