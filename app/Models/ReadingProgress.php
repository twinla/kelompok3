<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ReadingProgress extends Model
{
    protected $fillable = ['user_id', 'story_id', 'chapter_id', 'progress_percent', 'last_read_at', 'completed_at'];
    protected $casts = ['last_read_at' => 'datetime', 'completed_at' => 'datetime'];
    public function story(): BelongsTo { return $this->belongsTo(Story::class); }
    public function chapter(): BelongsTo { return $this->belongsTo(StoryChapter::class, 'chapter_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}