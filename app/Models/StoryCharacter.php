<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryCharacter extends Model
{
    protected $fillable = [
        'story_id',
        'name',
        'description',
        'image',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}
