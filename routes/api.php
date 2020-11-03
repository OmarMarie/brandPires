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
        'middleware' => ['auth:api', 'LastUserActivity']
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('brands', 'BrandController@index');
        Route::post('campaigns', 'BrandController@campaigns');
        Route::post('campaignDetails', 'BrandController@campaignDetails');
        Route::post('tanks', 'TankController@tanks');
        Route::post('updateTank', 'TankController@updateTank');
        Route::post('infoTank', 'TankController@infoTank');
        Route::get('gifts/{player_id}', 'BubbleController@gifts');
        Route::get('giftDetails/{id}', 'BubbleController@giftDetails');
        Route::get('playerChatting/{player_id}', 'ChattingController@playerChatting');
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
