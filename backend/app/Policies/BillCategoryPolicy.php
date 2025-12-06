<?php
namespace App\Policies;

use App\Models\BillCategory;
use App\Models\User;

class BillCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'house_owner';
    }

    public function view(User $user, BillCategory $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'house_owner';
    }

    public function update(User $user, BillCategory $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }

    public function delete(User $user, BillCategory $category): bool
    {
        return $user->tenant_id === $category->tenant_id;
    }
}
