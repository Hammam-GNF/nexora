<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_has_branches_and_users(): void
    {
        $company = Company::create([
            'code' => 'COMP-001',
            'name' => 'Nexora Demo',
            'legal_name' => 'PT Nexora Demo',
            'email' => 'company@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'is_active' => true,
        ]);

        $branch = Branch::create([
            'company_id' => $company->id,
            'code' => 'BR-001',
            'name' => 'Head Office',
            'address' => 'Jakarta',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $user = User::factory()->create();

        $company->users()->attach($user);
        $company->refresh();

        $this->assertTrue($company->branches->contains($branch));
        $this->assertTrue($company->users->contains($user));
    }

    public function test_branch_has_warehouse_and_users(): void
    {
        $company = Company::create([
            'code' => 'COMP-001',
            'name' => 'Nexora Demo',
            'legal_name' => 'PT Nexora Demo',
            'email' => 'company@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'is_active' => true,
        ]);

        $branch = Branch::create([
            'company_id' => $company->id,
            'code' => 'BR-001',
            'name' => 'Head Office',
            'address' => 'Jakarta',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $warehouse = Warehouse::create([
            'branch_id' => $branch->id,
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'address' => 'Jakarta',
            'is_active' => true,
        ]);

        $user = User::factory()->create();

        $branch->users()->attach($user);
        $branch->refresh();

        $this->assertTrue($branch->warehouses->contains($warehouse));
        $this->assertTrue($branch->users->contains($user));
    }

    public function test_warehouse_belongs_to_branch_and_has_users(): void
    {
        $company = Company::create([
            'code' => 'COMP-001',
            'name' => 'Nexora Demo',
            'legal_name' => 'PT Nexora Demo',
            'email' => 'company@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'is_active' => true,
        ]);

        $branch = Branch::create([
            'company_id' => $company->id,
            'code' => 'BR-001',
            'name' => 'Head Office',
            'address' => 'Jakarta',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $warehouse = Warehouse::create([
            'branch_id' => $branch->id,
            'code' => 'WH-001',
            'name' => 'Main Warehouse',
            'address' => 'Jakarta',
            'is_active' => true,
        ]);

        $user = User::factory()->create();

        $warehouse->users()->attach($user);
        $warehouse->refresh();

        $this->assertTrue($warehouse->branch->is($branch));
        $this->assertTrue($warehouse->users->contains($user));
    }
}
