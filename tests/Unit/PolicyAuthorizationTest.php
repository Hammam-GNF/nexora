<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_gate_uses_company_policy(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $user->companies()->attach($company);

        $this->assertTrue(
            $user->can('view', $company)
        );
    }

    public function test_gate_uses_branch_policy(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $user->branches()->attach($branch);

        $this->assertTrue(
            $user->can('view', $branch)
        );
    }

    public function test_gate_uses_warehouse_policy(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $warehouse = Warehouse::factory()->create();

        $user->warehouses()->attach($warehouse);

        $this->assertTrue(
            $user->can('view', $warehouse)
        );
    }

    public function test_gate_denies_company_access_for_non_member(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $this->assertFalse(
            $user->can('view', $company)
        );
    }

    public function test_gate_denies_branch_access_for_non_member(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $this->assertFalse(
            $user->can('view', $branch)
        );
    }

    public function test_gate_denies_warehouse_access_for_non_member(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $warehouse = Warehouse::factory()->create();

        $this->assertFalse(
            $user->can('view', $warehouse)
        );
    }
}
