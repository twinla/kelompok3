<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StoryComment extends Model
{
    protected $fillable = ['user_id', 'story_id', 'chapter_id', 'content'];
    public function story(): BelongsTo { return $this->belongsTo(Story::class); }
    public function chapter(): BelongsTo { return $this->belongsTo(StoryChapter::class, 'chapter_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}