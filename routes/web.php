<?php

use Twilio\Rest\Client;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@welcome');
Route::get('/test-users', function()
{
    dd(\App\User::pluck('first_name', 'id'));
});
Route::get('/artisan/migrate', 'HomeController@runArtisan');

Auth::routes();

Route::get('/tasks/reminder', 'TaskController@reminder');
Route::get('/home', 'HomeController@index')->name('home');

/*Admin routes*/
Route::group(['middleware' => 'role:Admin'], function () {
    // Get list of the products
    Route::get('/products', 'ProductController@index');
    // Get list of the customers
    Route::get('/customers', 'CustomerController@index');
    // Get specific customer by id
    Route::get('/customers/{customer}', 'CustomerController@get');
    // Store customer-product-prices
    Route::post('/prices/{customer}', 'CustomerProductPriceController@store');
    // Get users by type and name || email || phone
    Route::get('/users', 'UserController@index');
});
Route::group(['middleware' => 'role:nova-user'], function () {
    // Get specific customer by name || email
    Route::get('/customers/{name}/find', 'CustomerController@getByEmailOrName');
});
/*End of admin routes*/

/*Application Routes*/
// Re-order page
Route::get('/order', 'OrderController@index');
Route::group(['middleware' => 'auth'], function () {
    // Store the order
    Route::post('/order', 'OrderController@store')->name('orders.store');
});
/*End of application Routes*/
