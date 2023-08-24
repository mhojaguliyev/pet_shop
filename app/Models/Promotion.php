<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = ['id'];

    protected $casts = [
        'metadata' => 'array',
    ];
}
