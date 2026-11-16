<?php

namespace App\Policies;

use App\Models\Story;
use App\Models\User;

class StoryPolicy
{
    public function update(User $user, Story $story): bool
    {
        return $story->user_id !== null && (int) $story->user_id === (int) $user->id;
    }

    public function delete(User $user, Story $story): bool
    {
        return $story->user_id !== null && (int) $story->user_id === (int) $user->id;
    }
}
