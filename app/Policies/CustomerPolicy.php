<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Organization $organization): bool
    {
        return $user->organizations()->where('id', $organization->id)->exists();
    }
}
