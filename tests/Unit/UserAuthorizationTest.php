<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserAuthorizationTest extends TestCase
{
    public function test_user_can_check_permission(): void
    {
        $user = new User([
            'role' => UserRole::ADMIN,
        ]);

        $this->assertTrue(
            $user->hasPermission(Permission::USER_MANAGE)
        );
    }

    public function test_user_is_denied_unauthorized_permission(): void
    {
        $user = new User([
            'role' => UserRole::SALES,
        ]);

        $this->assertFalse(
            $user->hasPermission(Permission::USER_MANAGE)
        );
    }
}
