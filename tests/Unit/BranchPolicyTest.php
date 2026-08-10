<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\Branch;
use App\Models\User;
use App\Policies\BranchPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchPolicyTest extends TestCase
{
    use RefreshDatabase;

    private BranchPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new BranchPolicy();
    }

    public function test_user_with_view_permission_can_view_any_branch(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->assertTrue(
            $this->policy->viewAny($user)
        );
    }

    public function test_user_without_view_permission_cannot_view_any_branch(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $this->assertTrue(
            $user->hasPermission(Permission::BRANCH_VIEW)
        );

        $this->assertTrue(
            $this->policy->viewAny($user)
        );
    }

    public function test_user_can_view_branch_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $user->branches()->attach($branch);

        $this->assertTrue(
            $this->policy->view($user, $branch)
        );
    }

    public function test_user_cannot_view_branch_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $this->assertFalse(
            $this->policy->view($user, $branch)
        );
    }

    public function test_user_with_manage_permission_can_create_branch(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->assertTrue(
            $this->policy->create($user)
        );
    }

    public function test_user_without_manage_permission_cannot_create_branch(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SALES,
        ]);

        $this->assertFalse(
            $this->policy->create($user)
        );
    }

    public function test_user_with_manage_permission_can_update_branch_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $user->branches()->attach($branch);

        $this->assertTrue(
            $this->policy->update($user, $branch)
        );
    }

    public function test_user_cannot_update_branch_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $this->assertFalse(
            $this->policy->update($user, $branch)
        );
    }

    public function test_user_with_manage_permission_can_delete_branch_they_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $user->branches()->attach($branch);

        $this->assertTrue(
            $this->policy->delete($user, $branch)
        );
    }

    public function test_user_cannot_delete_branch_they_do_not_belong_to(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $branch = Branch::factory()->create();

        $this->assertFalse(
            $this->policy->delete($user, $branch)
        );
    }
}
