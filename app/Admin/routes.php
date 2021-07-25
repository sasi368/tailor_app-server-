<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

     $router->resource('logins', LoginController::class);
     $router->resource('add-branches', AddBranchController::class);
     $router->resource('add-customers', AddCustomerController::class);
     $router->resource('services', ServiceController::class);
     $router->resource('trackings', TrackingController::class);
     $router->resource('measurements', MeasurementController::class);

    
});
