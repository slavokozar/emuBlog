<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/03/2017
 * Time: 11:22
 */

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {

    Route::get('/', 'Admin\AdminController@index');

    Route::resource('/sports', 'Admin\SportController');

    Route::resource('/facilities', 'Admin\FacilityController');

    Route::resource('/users', 'Admin\UserController');

});