<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StoryChapter extends Model
{
    protected $fillable = ['story_id', 'chapter_number', 'title', 'content', 'status', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];
    public function story(): BelongsTo { return $this->belongsTo(Story::class); }
}