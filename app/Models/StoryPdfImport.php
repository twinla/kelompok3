<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryPdfImport extends Model
{
    protected $fillable = [
        'user_id',
        'story_id',
        'original_name',
        'file_sha256',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}
