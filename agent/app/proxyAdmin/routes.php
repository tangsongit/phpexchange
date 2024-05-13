<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('proxy-admin.route.prefix'),
    'namespace'     => config('proxy-admin.route.namespace'),
    'middleware'    => config('proxy-admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

});
