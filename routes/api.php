<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
   return 'BrandPiers';
});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    Route::post('reset', 'AuthController@reset');
    Route::post('verify', 'AuthController@verify');
    Route::post('validatePhone', 'AuthController@validateNumber');
    Route::post('requestVerificationCodeSignUp', 'AuthController@requestVerificationCodeSignUp');
    Route::post('requestVerificationCode', 'AuthController@requestVerificationCode');
    Route::post('validatePhone', 'AuthController@validatePhone');
    Route::post('validateEmail', 'AuthController@validateEmail');
    Route::post('validateUsername', 'AuthController@validateUsername');
    Route::post('validateEmail', 'AuthController@validateEmail');
    Route::post('validateUsername', 'AuthController@validateUsername');
    Route::get('countries', 'AuthController@getCountries');
    Route::post('cities', 'AuthController@getCities');

    Route::group([
        'middleware' => ['auth:api', 'LastUserActivity']
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('user/online', 'AuthController@online');
        Route::get('brands', 'BrandController@index');
        Route::post('campaigns', 'BrandController@campaigns');
        Route::post('campaignDetails', 'BrandController@campaignDetails');
        Route::post('tanks', 'TankController@tanks');
        Route::post('updateTank', 'TankController@updateTank');
        Route::post('infoTank', 'TankController@infoTank');
        Route::get('gifts/player', 'BubbleController@gifts');
        Route::post('giftDetails', 'BubbleController@giftDetails');
        Route::post('playerChatting', 'ChattingController@playerChatting');
        Route::get('chatDetails', 'ChattingController@chatDetails');
        Route::get('friends', 'ChattingController@friends');
        Route::post('sendFriendRequest', 'ChattingController@sendFriendRequest');
        Route::post('sendMessage', 'ChattingController@sendMessage');
        Route::post('contacts', 'AuthController@contacts');
        Route::post('getBubblesInLocation', 'FishingController@getBubblesInLocation');
        Route::get('hook/{id}', 'FishingController@hook');
        Route::get('levels', 'LevelController@levels');
        Route::post('infoLevel', 'LevelController@infoLevel');
    });
});

Route::get('testBubble', 'FishingController@test');
