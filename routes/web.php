<?php

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

Route::group(['middleware' => ['check-installer']], function () {
    //userLogin
    Route::get('/signin','AuthController@login')->name('login');
    Route::post('/postsignin','AuthController@postLogin')->name('postLogin');
    Route::get('verify-{id}-{verification_code}','AuthController@verifyEmail')->name('verifyEmail');

//forgot password
    Route::get('forget-password','AuthController@forgetPassword')->name('forgetPassword');
    Route::post('forget-password-process', 'AuthController@forgetPasswordProcess')->name('forgetPasswordProcess');
    Route::get('forget-password-change/{reset_code}', 'AuthController@forgetPasswordChange')->name('forgetPasswordChange');
    Route::get('forget-password-reset', 'AuthController@forgetPasswordReset')->name('forgetPasswordReset');
    Route::post('forget-password-reset-process/{reset_code}', 'AuthController@forgetPasswordResetProcess')->name('forgetPasswordResetProcess');
    Route::get('privacy-and-policy', 'AuthController@privacyPolicy')->name('privacyPolicy');
    Route::get('terms-and-conditions', 'AuthController@termsCondition')->name('termsCondition');

    require base_path('routes/link/admin.php');

    Route::group(['middleware' =>['auth']], function () {
        //logout
        Route::get('/logout', 'AuthController@logout')->name('logOut');
    });
});
