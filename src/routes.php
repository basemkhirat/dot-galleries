<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend"],
    "namespace" => "Dot\\Galleries\\Controllers"
], function ($route) {
    $route->group(["prefix" => "galleries"], function ($route) {
        $route->any('/delete', ["as" => "admin.galleries.delete", "uses" => "GalleriesController@delete"]);
        $route->any('/save', ["as" => "admin.galleries.save", "uses" => "GalleriesController@save"]);
        $route->any('/files', ["as" => "admin.galleries.files", "uses" => "GalleriesController@files"]);
        $route->any('/create', ["as" => "admin.galleries.create", "uses" => "GalleriesController@create"]);
        $route->any('/{id?}', ["as" => "admin.galleries.show", "uses" => "GalleriesController@index"]);
        $route->any('/content', ["as" => "admin.galleries.content", "uses" => "GalleriesController@content"]);
        $route->any('/{id}/edit', ["as" => "admin.galleries.edit", "uses" => "GalleriesController@edit"]);
        $route->any('/get/{offset?}', ["as" => "admin.galleries.ajax", "uses" => "GalleriesController@get"]);
    });
});

/*
 * API
 */

Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"],
    "namespace" => "Dot\\Galleries\\Controllers"
], function ($route) {
    $route->get("/galleries/show", "GalleriesApiController@show");
    $route->post("/galleries/create", "GalleriesApiController@create");
    $route->post("/galleries/update", "GalleriesApiController@update");
    $route->post("/galleries/destroy", "GalleriesApiController@destroy");
});



