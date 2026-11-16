<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LibraryEntry extends Model
{
    protected $fillable = ['user_id', 'story_id', 'shelf'];
    public function story(): BelongsTo { return $this->belongsTo(Story::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}