<?php

namespace Tests\Unit;

use App\Enums\Permission;
use PHPUnit\Framework\TestCase;

class PermissionTest extends TestCase
{
    public function test_permission_contains_all_supported_permissions(): void
    {
        $this->assertSame([
            'company.view',
            'company.manage',
            'user.view',
            'user.manage',
            'branch.view',
            'branch.manage',
            'warehouse.view',
            'warehouse.manage',
        ], array_column(Permission::cases(), 'value'));
    }
}
