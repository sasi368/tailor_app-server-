<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* 
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', 'App\Http\Controllers\api\LoginController@register');
Route::post('login', 'App\Http\Controllers\api\LoginController@login');


//show and add services
Route::post('add_services','App\Http\Controllers\api\ServiceController@add_services');
Route::get('show_services','App\Http\Controllers\api\ServiceController@show_services'); 



//for add customer and show customers
Route::post('add_customer','App\Http\Controllers\api\CustomerController@add_customer');
Route::get('show_customers','App\Http\Controllers\api\CustomerController@show_customers');
//show customer details by id
Route::post('show_customer_details','App\Http\Controllers\api\CustomerController@show_customer_details');
//show customers by branch
Route::post('show_customers_by_branch','App\Http\Controllers\api\CustomerController@show_customers_by_branch');
//show customer by code
Route::post('show_customers_by_code','App\Http\Controllers\api\CustomerController@show_customers_by_code');


//add and show measurements 
Route::post('add_measurements','App\Http\Controllers\api\MeasurementController@add_measurements');
Route::get('show_all_measurements','App\Http\Controllers\api\MeasurementController@show_all_measurements');
//show measurement details by customer_id and service name
Route::post('show_measurement_details','App\Http\Controllers\api\MeasurementController@show_measurement_details');
//show measurement details by taken_date
Route::post('show_today_by_date','App\Http\Controllers\api\MeasurementController@show_today_by_date');
Route::post('show_measurements_by_date','App\Http\Controllers\api\MeasurementController@show_measurements_by_date');
Route::post('update_measurement_position','App\Http\Controllers\api\MeasurementController@update_measurement_position');
Route::post('show_measurement_details_by_id','App\Http\Controllers\api\MeasurementController@show_measurement_details_by_id');
Route::post('show_measurement_details_by_branch','App\Http\Controllers\api\MeasurementController@show_measurement_details_by_branch');


//add branches and show branches
Route::post('add_branches','App\Http\Controllers\api\BranchController@add_branches');

Route::get('show_branches','App\Http\Controllers\api\BranchController@show_branches');



//add and show tracking status
Route::post('add_tracking','App\Http\Controllers\api\TrackingController@add_tracking');
Route::post('show_tracking_position','App\Http\Controllers\api\TrackingController@show_tracking_position');
Route::get('show_all_status','App\Http\Controllers\api\TrackingController@show_all_status');
Route::post('update_tracking_position','App\Http\Controllers\api\TrackingController@update_tracking_position');
//show order status by id
Route::post('show_order_status','App\Http\Controllers\api\TrackingController@show_order_status');