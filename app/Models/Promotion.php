<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Promotion extends Model
{
    /** @use HasFactory<Factory<self>> */
    use HasFactory;

    use HasUuid;

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }
}
