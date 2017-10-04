<?php

namespace Dot\Galleries;

use Illuminate\Support\Facades\Auth;
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

            if (Auth::user()->can("galleries.manage")) {
                $menu->item('galleries', trans("admin::common.galleries"), URL::to(ADMIN . '/galleries'))
                    ->order(5)
                    ->icon("fa-camera");
            }
        });
    }

}
