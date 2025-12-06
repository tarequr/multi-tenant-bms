<?php
namespace App\Policies;

use App\Models\User;

class TenantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function assign(User $user): bool
    {
        return $user->role === 'admin';
    }
}
