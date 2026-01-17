<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ImagePolicy
{
    public function view(User $user, Image $image): bool
    {
        return $image->users()
            ->where('users.id', $user->id)
            ->exists();
    }

    public function delete(User $user, Image $image): bool
    {
        return $image->users()
            ->where('users.id', $user->id)
            ->exists();
    }
}
