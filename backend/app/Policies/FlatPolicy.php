<?php
namespace App\Policies;

use App\Models\Flat;
use App\Models\User;

class FlatPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'house_owner']);
    }

    public function view(User $user, Flat $flat): bool
    {
        return $user->role === 'admin' || $user->tenant_id === $flat->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'house_owner';
    }

    public function update(User $user, Flat $flat): bool
    {
        return $user->tenant_id === $flat->tenant_id;
    }

    public function delete(User $user, Flat $flat): bool
    {
        return $user->tenant_id === $flat->tenant_id;
    }
}
