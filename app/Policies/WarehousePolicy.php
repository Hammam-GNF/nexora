<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\User;
use App\Models\Warehouse;

class WarehousePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::WAREHOUSE_VIEW);
    }

    public function view(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermission(Permission::WAREHOUSE_VIEW)
            && $user->canAccessWarehouse($warehouse);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::WAREHOUSE_MANAGE);
    }

    public function update(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermission(Permission::WAREHOUSE_MANAGE)
            && $user->canAccessWarehouse($warehouse);
    }

    public function delete(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermission(Permission::WAREHOUSE_MANAGE)
            && $user->canAccessWarehouse($warehouse);
    }
}
