<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
), function ($route) {
    $route->group(array("prefix" => "galleries"), function ($route) {

        $route->any('/delete', array("as" => "admin.galleries.delete", "uses" => "Dot\Galleries\Controllers\GalleriesController@delete"));
        $route->any('/save', array("as" => "admin.galleries.save", "uses" => "Dot\Galleries\Controllers\GalleriesController@save"));
        $route->any('/files', array("as" => "admin.galleries.files", "uses" => "Dot\Galleries\Controllers\GalleriesController@files"));
        $route->any('/create', array("as" => "admin.galleries.create", "uses" => "Dot\Galleries\Controllers\GalleriesController@create"));
        $route->any('/{id?}', array("as" => "admin.galleries.show", "uses" => "Dot\Galleries\Controllers\GalleriesController@index"));

        $route->any('/content', array("as" => "admin.galleries.content", "uses" => "Dot\Galleries\Controllers\GalleriesController@content"));
        $route->any('/{id}/edit', array("as" => "admin.galleries.edit", "uses" => "Dot\Galleries\Controllers\GalleriesController@edit"));
        $route->any('/get/{offset?}', array("as" => "admin.galleries.ajax", "uses" => "Dot\Galleries\Controllers\GalleriesController@get"));
    });
});

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
    $route->get("/galleries/show", "Dot\Galleries\Controllers\GalleriesApiController@show");
    $route->post("/galleries/create", "Dot\Galleries\Controllers\GalleriesApiController@create");
    $route->post("/galleries/update", "Dot\Galleries\Controllers\GalleriesApiController@update");
    $route->post("/galleries/destroy", "Dot\Galleries\Controllers\GalleriesApiController@destroy");
});



