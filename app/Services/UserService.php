<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function all(): Collection
    {
        return User::query()
            ->where('id', '<>', Auth::user()->id)
            ->get(['id', 'name', 'email', 'has_dashboard_access']);
    }

    public function toggleDashboardAccess($id)
    {
        $user = User::findOrFail($id, ['id', 'has_dashboard_access']);
        $user->update(['has_dashboard_access' => !$user->has_dashboard_access]);

        return $user;
    }
}
