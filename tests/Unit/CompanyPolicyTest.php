<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Policies\CompanyPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyPolicyTest extends TestCase
{
    use RefreshDatabase;

    private CompanyPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new CompanyPolicy();
    }

    public function test_user_with_view_permission_can_view_any_company(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->assertTrue(
            $this->policy->viewAny($user)
        );
    }

    public function test_user_without_view_permission_cannot_view_any_company(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $this->assertTrue(
            $user->hasPermission(Permission::COMPANY_VIEW)
        );

        $this->assertTrue(
            $this->policy->viewAny($user)
        );
    }

    public function test_user_can_view_company_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $user->companies()->attach($company);

        $this->assertTrue(
            $this->policy->view($user, $company)
        );
    }

    public function test_user_cannot_view_company_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $this->assertFalse(
            $this->policy->view($user, $company)
        );
    }

    public function test_user_with_manage_permission_can_create_company(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->assertTrue(
            $this->policy->create($user)
        );
    }

    public function test_user_without_manage_permission_cannot_create_company(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $this->assertFalse(
            $this->policy->create($user)
        );
    }

    public function test_user_with_manage_permission_can_update_company_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $user->companies()->attach($company);

        $this->assertTrue(
            $this->policy->update($user, $company)
        );
    }

    public function test_user_cannot_update_company_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $this->assertFalse(
            $this->policy->update($user, $company)
        );
    }

    public function test_user_with_manage_permission_can_delete_company_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $user->companies()->attach($company);

        $this->assertTrue(
            $this->policy->delete($user, $company)
        );
    }

    public function test_user_cannot_delete_company_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::factory()->create();

        $this->assertFalse(
            $this->policy->delete($user, $company)
        );
    }
}
