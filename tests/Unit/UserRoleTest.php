<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_user_role_contains_all_supported_roles(): void
    {
        $this->assertSame([
            'owner',
            'admin',
            'manager',
            'sales',
            'purchasing',
            'warehouse',
            'finance',
        ], array_column(UserRole::cases(), 'value'));
    }
}
