<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraRules extends Model
{
    /** @use HasFactory<\Database\Factories\ExtraRulesFactory> */
    use HasFactory;

    public function boardTemplates()
    {
        return $this->belongsToMany(BoardTemplate::class);
    }
}
