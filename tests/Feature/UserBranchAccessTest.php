<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBranchAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_branch_they_belong_to(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $branch = Branch::factory()->create([
            'company_id' => $company->id,
        ]);

        $user->branches()->attach($branch);

        $this->assertTrue(
            $user->canAccessBranch($branch)
        );
    }

    public function test_user_cannot_access_branch_they_do_not_belong_to(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $branch = Branch::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->assertFalse(
            $user->canAccessBranch($branch)
        );
    }

    public function test_company_membership_does_not_grant_branch_access(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $branch = Branch::factory()->create([
            'company_id' => $company->id,
        ]);

        $user->companies()->attach($company);

        $this->assertTrue(
            $user->canAccessCompany($company)
        );

        $this->assertFalse(
            $user->canAccessBranch($branch)
        );
    }
}
