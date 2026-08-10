<?php

namespace Tests\Unit\Support\Tenancy;

use App\Models\Company;
use App\Support\Tenancy\CurrentCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrentCompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_set_and_get_current_company(): void
    {
        $company = Company::create([
            'code' => 'NXR',
            'name' => 'Nexora Demo',
        ]);

        $context = app(CurrentCompany::class);

        $context->set($company);

        $this->assertSame($company->id, $context->id());
        $this->assertTrue($context->check());
        $this->assertTrue($context->get()->is($company));
    }

    public function test_it_can_clear_current_company(): void
    {
        $company = Company::create([
            'code' => 'NXR',
            'name' => 'Nexora Demo',
        ]);

        $context = app(CurrentCompany::class);

        $context->set($company);
        $context->clear();

        $this->assertNull($context->id());
        $this->assertFalse($context->check());
        $this->assertNull($context->get());
    }
}
