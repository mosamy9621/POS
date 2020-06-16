<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(
            function (){
                Route::get('/index','DashboardController@index')->name('index');

                Route::resource('users','UserController');


                Route::resource('categories','CategoryController');

                Route::resource('products','ProductController');

                Route::resource('clients','ClientController');
                Route::resource('clients.orders','Client\OrderController');



            }
        );

});
