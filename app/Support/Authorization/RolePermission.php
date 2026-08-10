<?php

namespace App\Support\Authorization;

use App\Enums\Permission;
use App\Enums\UserRole;

final class RolePermission
{
    /**
     * @return list<Permission>
     */
    public static function for(UserRole $role): array
    {
        return match ($role) {
            UserRole::OWNER => Permission::cases(),

            UserRole::ADMIN => Permission::cases(),

            UserRole::MANAGER => [
                Permission::COMPANY_VIEW,
                Permission::USER_VIEW,
                Permission::BRANCH_VIEW,
                Permission::WAREHOUSE_VIEW,
            ],

            UserRole::SALES => [
                Permission::COMPANY_VIEW,
                Permission::BRANCH_VIEW,
                Permission::WAREHOUSE_VIEW,
            ],

            UserRole::PURCHASING => [
                Permission::COMPANY_VIEW,
                Permission::BRANCH_VIEW,
                Permission::WAREHOUSE_VIEW,
            ],

            UserRole::WAREHOUSE => [
                Permission::COMPANY_VIEW,
                Permission::BRANCH_VIEW,
                Permission::WAREHOUSE_VIEW,
                Permission::WAREHOUSE_MANAGE,
            ],

            UserRole::FINANCE => [
                Permission::COMPANY_VIEW,
                Permission::BRANCH_VIEW,
                Permission::WAREHOUSE_VIEW,
            ],
        };
    }

    public static function allows(UserRole $role, Permission $permission): bool
    {
        return in_array($permission, self::for($role), true);
    }
}
