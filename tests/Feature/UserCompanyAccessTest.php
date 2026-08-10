<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCompanyAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_company_they_belong_to(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $user->companies()->attach($company);

        $this->assertTrue(
            $user->canAccessCompany($company)
        );
    }

    public function test_user_cannot_access_company_they_do_not_belong_to(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->assertFalse(
            $user->canAccessCompany($company)
        );
    }
}
