<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdministrator()) {
            return true;
        }
    }

    public function dashboard(User $user): bool
    {
        return $user->has_dashboard_access;
    }

    public function updateAccess(User $user): bool
    {
        return $user->isAdministrator();
    }
}
