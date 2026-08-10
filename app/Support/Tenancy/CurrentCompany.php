<?php

namespace App\Support\Tenancy;

use App\Models\Company;
use Illuminate\Contracts\Session\Session;

class CurrentCompany
{
    public function __construct(
        private readonly Session $session,
    ) {}

    public function set(Company $company): void
    {
        $this->session->put('current_company_id', $company->id);
    }

    public function get(): ?Company
    {
        $companyId = $this->session->get('current_company_id');

        if (! $companyId) {
            return null;
        }

        return Company::find($companyId);
    }

    public function id(): ?int
    {
        return $this->session->get('current_company_id');
    }

    public function check(): bool
    {
        return $this->id() !== null;
    }

    public function clear(): void
    {
        $this->session->forget('current_company_id');
    }
}
