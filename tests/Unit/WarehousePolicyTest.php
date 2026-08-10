<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\Branch;
use App\Models\Warehouse;
use App\Models\User;
use App\Policies\WarehousePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarehousePolicyTest extends TestCase
{
    use RefreshDatabase;

    private WarehousePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new WarehousePolicy();
    }

    public function test_user_with_view_permission_can_view_any_warehouse(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $this->assertTrue(
            $this->policy->viewAny($user)
        );
    }

    public function test_user_can_view_warehouse_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $branch = Branch::factory()->create();

        $warehouse = Warehouse::factory()->create([
            'branch_id' => $branch->id,
        ]);

        $user->warehouses()->attach($warehouse);

        $this->assertTrue(
            $this->policy->view($user, $warehouse)
        );
    }

    public function test_user_cannot_view_warehouse_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $warehouse = Warehouse::factory()->create();

        $this->assertFalse(
            $this->policy->view($user, $warehouse)
        );
    }

    public function test_user_with_manage_permission_can_create_warehouse(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::WAREHOUSE,
        ]);

        $this->assertTrue(
            $this->policy->create($user)
        );
    }

    public function test_user_without_manage_permission_cannot_create_warehouse(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $this->assertFalse(
            $this->policy->create($user)
        );
    }

    public function test_user_with_manage_permission_can_update_warehouse_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::WAREHOUSE,
        ]);

        $warehouse = Warehouse::factory()->create();

        $user->warehouses()->attach($warehouse);

        $this->assertTrue(
            $this->policy->update($user, $warehouse)
        );
    }

    public function test_user_cannot_update_warehouse_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::WAREHOUSE,
        ]);

        $warehouse = Warehouse::factory()->create();

        $this->assertFalse(
            $this->policy->update($user, $warehouse)
        );
    }

    public function test_user_with_manage_permission_can_delete_warehouse_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::WAREHOUSE,
        ]);

        $warehouse = Warehouse::factory()->create();

        $user->warehouses()->attach($warehouse);

        $this->assertTrue(
            $this->policy->delete($user, $warehouse)
        );
    }

    public function test_user_cannot_delete_warehouse_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::WAREHOUSE,
        ]);

        $warehouse = Warehouse::factory()->create();

        $this->assertFalse(
            $this->policy->delete($user, $warehouse)
        );
    }
}
