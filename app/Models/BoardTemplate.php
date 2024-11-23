<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\BoardTemplateFactory> */
    use HasFactory;

    protected $casts = [
        'resources' => 'json',
        'extra_rules' => 'json',
    ];
}
