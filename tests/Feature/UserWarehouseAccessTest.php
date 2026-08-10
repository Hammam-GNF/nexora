<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserWarehouseAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_warehouse_they_belong_to(): void
    {
        $warehouse = Warehouse::factory()->create();
        $user = User::factory()->create();

        $user->warehouses()->attach($warehouse);

        $this->assertTrue(
            $user->canAccessWarehouse($warehouse)
        );
    }

    public function test_user_cannot_access_warehouse_they_do_not_belong_to(): void
    {
        $warehouse = Warehouse::factory()->create();
        $user = User::factory()->create();

        $this->assertFalse(
            $user->canAccessWarehouse($warehouse)
        );
    }

    public function test_company_membership_does_not_grant_warehouse_access(): void
    {
        $company = Company::factory()->create();
        $branch = Branch::factory()->create([
            'company_id' => $company->id,
        ]);
        $warehouse = Warehouse::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $user = User::factory()->create();

        $user->companies()->attach($company);

        $this->assertFalse(
            $user->canAccessWarehouse($warehouse)
        );
    }

    public function test_branch_membership_does_not_grant_warehouse_access(): void
    {
        $branch = Branch::factory()->create();
        $warehouse = Warehouse::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $user = User::factory()->create();

        $user->branches()->attach($branch);

        $this->assertFalse(
            $user->canAccessWarehouse($warehouse)
        );
    }
}
