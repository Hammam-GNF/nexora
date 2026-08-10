<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Support\Authorization\RolePermission;
use PHPUnit\Framework\TestCase;

class RolePermissionTest extends TestCase
{
    public function test_owner_has_all_permissions(): void
    {
        $this->assertSame(
            Permission::cases(),
            RolePermission::for(UserRole::OWNER)
        );
    }

    public function test_admin_has_all_permissions(): void
    {
        $this->assertSame(
            Permission::cases(),
            RolePermission::for(UserRole::ADMIN)
        );
    }

    public function test_manager_has_read_only_organization_permissions(): void
    {
        $this->assertTrue(
            RolePermission::allows(UserRole::MANAGER, Permission::COMPANY_VIEW)
        );

        $this->assertTrue(
            RolePermission::allows(UserRole::MANAGER, Permission::USER_VIEW)
        );

        $this->assertFalse(
            RolePermission::allows(UserRole::MANAGER, Permission::USER_MANAGE)
        );

        $this->assertFalse(
            RolePermission::allows(UserRole::MANAGER, Permission::COMPANY_MANAGE)
        );
    }

    public function test_warehouse_can_manage_warehouse(): void
    {
        $this->assertTrue(
            RolePermission::allows(
                UserRole::WAREHOUSE,
                Permission::WAREHOUSE_MANAGE
            )
        );
    }

    public function test_operational_roles_cannot_manage_users(): void
    {
        $roles = [
            UserRole::MANAGER,
            UserRole::SALES,
            UserRole::PURCHASING,
            UserRole::WAREHOUSE,
            UserRole::FINANCE,
        ];

        foreach ($roles as $role) {
            $this->assertFalse(
                RolePermission::allows($role, Permission::USER_MANAGE)
            );
        }
    }

    public function test_role_permission_check_returns_false_for_unauthorized_permission(): void
    {
        $this->assertFalse(
            RolePermission::allows(
                UserRole::SALES,
                Permission::COMPANY_MANAGE
            )
        );
    }
}
