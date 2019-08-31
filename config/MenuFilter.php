<?php

namespace App;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
//use Laratrust;
use App\Http\Controllers\Permissions;

class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {

        if (isset($item['can']) && !Permissions::getRolePermissions($item['can'])) {
            return false;
        }

        return $item;
    }
}