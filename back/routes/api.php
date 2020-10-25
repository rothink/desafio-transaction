<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/auth', function (Request $request) {
    return $request->user();
});

Route::post('/user/cadastrar', 'UserController@cadastrar');
Route::post('/user/recuperar-senha', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('/user/resetar-senha', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth:api'], function () {

    /**
     * Auth / Me
     */
    Route::get('/me', 'AuthController@me');

    /**
     * User
     */
    Route::get('user/pre-requisite', 'UserController@preRequisite');
    Route::resource('user', 'UserController')->only([
        'index', 'store'
    ]);

    /**
     * Transaferecia / Transaction
     *
     * O método resource, engloba todo o REST
     *  GET transaction - only
     *  GET transaction/id
     *  POST transaction - only
     *  PUT transaction/id
     *  DELETE transaction/id
     *
     * https://stackoverflow.com/questions/23505875/laravel-routeresource-vs-routecontroller
     */
    Route::get('transaction/pre-requisite', 'TransferenciaController@preRequisite');
    Route::resource('transaction', 'TransferenciaController')->only([
        'index', 'store'
    ]);
});
