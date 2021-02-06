<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
   return 'BrandPiers';
});
Route::group([
    'prefix' => 'auth'
], function () {
    // ارسال ايمل ل تغير كلمة المرور
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    // تغير كلمة السر
    Route::post('password/reset', 'ResetPasswordController@reset');
    // ارسال رابط ل تحقق من الايمل
    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    // التحقق من الايمل
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    // تسجيل الدخول من خلال رقم الهاتف او اسم المستخدم او الايمل
    Route::post('login', 'AuthController@login');
    // تسجيل المستخدم
    Route::post('signup', 'AuthController@signUp');
    // اعادة ارسال رمز التحقق للهاتف
    Route::post('reset', 'AuthController@reset');
    // التأكد من رمز التحقق المرسل الى رقم الهاتف
    Route::post('verify', 'AuthController@verify');
    // التأكد من رقم الهاتف انه غير موجود
    Route::post('validatePhone', 'AuthController@validateNumber');
    // طلب رمز تحقق اثناء عملية التسجيل
    Route::post('requestVerificationCodeSignUp', 'AuthController@requestVerificationCodeSignUp');
    // طلب رمز تحقق
    Route::post('requestVerificationCode', 'AuthController@requestVerificationCode');
    // التحقق من رقم الهاتف انه غير مجوز
    Route::post('validatePhone', 'AuthController@validatePhone');
    // التحقق من الايمل غير محجوز
    Route::post('validateEmail', 'AuthController@validateEmail');
    // التحقق من اسم المستخدم
    Route::post('validateUsername', 'AuthController@validateUsername');
    // التحقق من اسم المستخدم
    Route::post('validateUsername', 'AuthController@validateUsername');
    // ارجاع الدول
    Route::get('countries', 'AuthController@getCountries');
    // ارجاع المحافظات
    Route::post('cities', 'AuthController@getCities');

    Route::group([
        // لمعرفة اخر نشاط  للويوزر
        'middleware' => ['auth:api', 'LastUserActivity']
    ], function() {
        // تسجيل الخروج
        Route::get('logout', 'AuthController@logout');
        // ارجع معلومات اليوزر من خلال token
        Route::get('user', 'AuthController@user');
        // تخزين دخول وخروج اليوزر من التطبيق
        Route::post('user/online', 'AuthController@online');
        // ارجاع علامة التجارية + الحملات التي تخصها
        Route::get('brands', 'BrandController@index');
        // ارجاع الحملات
        Route::post('campaigns', 'BrandController@campaigns');
        // ارجاع تفاصيل الحملة
        Route::post('campaignDetails', 'BrandController@campaignDetails');
        // ارجاع الخزانات
        Route::post('tanks', 'TankController@tanks');
        // رفع مستوى الخزان
        Route::post('updateTank', 'TankController@updateTank');
        // ارجاع معلومات الخزان
        Route::post('infoTank', 'TankController@infoTank');
        // ارجاع هدايا الاعب
        Route::get('gifts/player', 'BubbleController@gifts');
        // ارجاع تفاصيل الهدية
        Route::post('giftDetails', 'BubbleController@giftDetails');
        // ارجاع محدثات الاعب
        Route::post('playerChatting', 'ChattingController@playerChatting');
        // ارجاع تفاصيل المحادثة
        Route::get('chatDetails', 'ChattingController@chatDetails');
        // ارجاع الاصدقاء داخل التطبيق
        Route::get('friends', 'ChattingController@friends');
        // ارسال طلب صداقة
        Route::post('sendFriendRequest', 'ChattingController@sendFriendRequest');
        // ارجاع طلبات الصداقة المرسلة
        Route::get('friendsRequest', 'ChattingController@friendRequest');
        // الموافقة على طلب الصداقة
        Route::post('approveRequest', 'ChattingController@approveRequest');
        // عدم الموافقة على طلب الصداقة
        Route::post('disapproveRequest', 'ChattingController@disapproveRequest');
        // ارسال رسالة بالمحادثة
        Route::post('sendMessage', 'ChattingController@sendMessage');
        // ارجاع جهات الاتصال
        Route::post('contacts', 'AuthController@contacts');
         // ارجاع Bubbles في مكان محدد
        Route::post('getBubblesInLocation', 'FishingController@getBubblesInLocation');
        // صيد Bubbles
        Route::get('hook/{id}', 'FishingController@hook');
        // انواع المستوى في التطبيق
        Route::get('levels', 'LevelController@levels');
        // ارجاع تفاصيل المستوى
        Route::post('infoLevel', 'LevelController@infoLevel');
    });
});

Route::get('testBubble', 'FishingController@test');
