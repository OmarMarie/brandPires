<?php

Route::get('/', function (){
   return 'BrandPiers';
});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('brands', 'BrandController@index');
        Route::get('campaigns/{id}', 'BrandController@campaigns');
        Route::get('campaignDetails/{id}', 'BrandController@campaignDetails');
        Route::get('tanks/{id}', 'TankController@tanks');
        Route::post('updateTank', 'TankController@updateTank');
        Route::get('infoTank/{id}', 'TankController@infoTank');
        Route::get('gifts/{player_id}', 'BubbleController@gifts');
        Route::get('giftDetails/{id}', 'BubbleController@giftDetails');
        Route::get('playerChatting/{player_id}', 'ChattingController@playerChatting');
        Route::get('chatDetails', 'ChattingController@chatDetails');
        Route::get('friends/{id}', 'ChattingController@friends');
        Route::post('sendFriendRequest', 'ChattingController@sendFriendRequest');
        Route::post('sendMessage', 'ChattingController@sendMessage');
        Route::post('contacts', 'AuthController@contacts');
        Route::post('getBubblesInLocation', 'FishingController@getBubblesInLocation');
        Route::get('hook/{id}', 'FishingController@hook');
    });
});

Route::get('testBubble', 'FishingController@test');
