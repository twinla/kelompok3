<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{
    protected $table = 'stories';

    protected $fillable = [
        'user_id', 'title', 'slug', 'author', 'genre', 'cover',
        'synopsis', 'content', 'status',
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

    public function chapters(): HasMany
    {
        return $this->hasMany(StoryChapter::class)->orderBy('chapter_number');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(StoryLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(StoryComment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(StoryRating::class);
    }

    public function libraryEntries(): HasMany
    {
        return $this->hasMany(LibraryEntry::class);
    }

    public function readingProgress(): HasMany
    {
        return $this->hasMany(ReadingProgress::class);
    }
}
