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
    ];

    protected $casts = [
        'resources' => 'json',
    ];

    public function setResourcesDirectly(string $resources)
    {
        $this->attributes['resources'] = $resources;
    }

    public function extraRules()
    {
        return $this->belongsToMany(ExtraRule::class)->withPivot(['value']);
    }
}
