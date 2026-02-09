<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;

class LinkPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin')
            || $user->hasRole('editor')
            || $user->hasRole('viewer');
    }

    public function view(User $user, Link $link): bool
    {
        if ($user->hasRole('admin')) return true;

        return $link->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('editor');
    }

    public function update(User $user, Link $link): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->hasRole('editor') && $link->user_id === $user->id;
    }

    public function delete(User $user, Link $link): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->hasRole('editor') && $link->user_id === $user->id;
    }
}
