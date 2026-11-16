<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{
    protected $table = 'stories';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'author',
        'genre',
        'cover',
        'synopsis',
        'content',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(StoryCharacter::class)->latest();
    }
}
