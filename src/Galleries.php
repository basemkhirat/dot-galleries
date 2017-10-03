<?php

namespace Dot\Galleries;

use Gate;
use Navigation;
use URL;

class Galleries extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Gate::allows("galleries.manage")) {
                $menu->item('galleries', trans("admin::common.galleries"), URL::to(ADMIN . '/galleries'))
                    ->order(5)
                    ->icon("fa-camera");
            }
        });
    }

}
