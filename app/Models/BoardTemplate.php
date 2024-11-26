<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\BoardTemplateFactory> */
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'size_x',
        'size_y',
        'resources',
        'extra_rules',
    ];

    protected $casts = [
        'resources' => 'json',
        'extra_rules' => 'json',
    ];

    public function setResourcesDirectly(string $resources)
    {
        $this->attributes['resources'] = $resources;
    }

    public function extraRules()
    {
        return $this->belongsToMany(ExtraRules::class);
    }
}
