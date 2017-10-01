<?php

namespace Dot\Galleries;

use Gate;
use Navigation;
use URL;

class Plugin extends \Dot\Platform\Plugin
{

    public $permissions = [
        "manage"
    ];

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            if (Gate::allows("galleries.manage")) {
                $menu->item('galleries', trans("admin::common.galleries"), URL::to(ADMIN . '/galleries'))
                    ->order(5)
                    ->icon("fa-camera");
            }
        });

        include __DIR__ . "/routes.php";

    }

}
