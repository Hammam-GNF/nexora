<?php

namespace App\Enums;

enum Permission: string
{
    case COMPANY_VIEW = 'company.view';
    case COMPANY_MANAGE = 'company.manage';

    case USER_VIEW = 'user.view';
    case USER_MANAGE = 'user.manage';

    case BRANCH_VIEW = 'branch.view';
    case BRANCH_MANAGE = 'branch.manage';

    case WAREHOUSE_VIEW = 'warehouse.view';
    case WAREHOUSE_MANAGE = 'warehouse.manage';
}
