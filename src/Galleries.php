<?php

namespace Dot\Galleries;

use Illuminate\Support\Facades\Auth;
use Navigation;

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
                $menu->item('galleries', trans("admin::common.galleries"), route("admin.galleries.show"))
                    ->order(5)
                    ->icon("fa-camera");
            }
        });
    }

}
