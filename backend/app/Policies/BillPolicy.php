<?php
namespace App\Policies;

use App\Models\Bill;
use App\Models\User;

class BillPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'house_owner']);
    }

    public function view(User $user, Bill $bill): bool
    {
        return $user->role === 'admin' || $user->tenant_id === $bill->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'house_owner';
    }

    public function update(User $user, Bill $bill): bool
    {
        return $user->tenant_id === $bill->tenant_id;
    }
}
