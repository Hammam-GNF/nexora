<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AuthorizationGateTest extends TestCase
{
    public function test_gate_allows_user_with_required_permission(): void
    {
        $user = new User([
            'role' => UserRole::ADMIN,
        ]);

        $this->assertTrue(
            Gate::forUser($user)->allows('user.manage')
        );
    }

    public function test_gate_denies_user_without_required_permission(): void
    {
        $user = new User([
            'role' => UserRole::SALES,
        ]);

        $this->assertFalse(
            Gate::forUser($user)->allows('user.manage')
        );
    }

    public function test_gate_registers_all_permissions(): void
    {
        $user = new User([
            'role' => UserRole::OWNER,
        ]);

        foreach (Permission::cases() as $permission) {
            $this->assertTrue(
                Gate::forUser($user)->allows($permission->value)
            );
        }
    }
}
