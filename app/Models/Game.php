<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $fillable = [
        'template_id',
        'player1_id',
        'player2_id',
        'player1_state',
        'player2_state',
    ];

    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id');
    }

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopePlaysIn(Builder $query, int $user_id): void
    {
        $query->where('player1_id', $user_id)->orWhere('player2_id', $user_id);
    }
}
