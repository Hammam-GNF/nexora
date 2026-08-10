<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::COMPANY_VIEW);
    }

    public function view(User $user, Company $company): bool
    {
        return $user->hasPermission(Permission::COMPANY_VIEW)
            && $user->canAccessCompany($company);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::COMPANY_MANAGE);
    }

    public function update(User $user, Company $company): bool
    {
        return $user->hasPermission(Permission::COMPANY_MANAGE)
            && $user->canAccessCompany($company);
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->hasPermission(Permission::COMPANY_MANAGE)
            && $user->canAccessCompany($company);
    }
}
