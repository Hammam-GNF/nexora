<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::BRANCH_VIEW);
    }

    public function view(User $user, Branch $branch): bool
    {
        return $user->hasPermission(Permission::BRANCH_VIEW)
            && $user->canAccessBranch($branch);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::BRANCH_MANAGE);
    }

    public function update(User $user, Branch $branch): bool
    {
        return $user->hasPermission(Permission::BRANCH_MANAGE)
            && $user->canAccessBranch($branch);
    }

    public function delete(User $user, Branch $branch): bool
    {
        return $user->hasPermission(Permission::BRANCH_MANAGE)
            && $user->canAccessBranch($branch);
    }
}
