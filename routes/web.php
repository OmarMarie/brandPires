<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/

HomeController:Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'], function () {

    Route::group(['middleware' => ['auth']], function () {

        //عرض لوحة لتحكم
        Route::get('/dashboard', 'HomeController@index')->name('home');
        //عرض لوحة الصفحة الرئسية
        Route::get('/', 'HomeController@index')->name('home');
        // ارجاع المناطق
        Route::get('getCities/{country_id?}', 'HomeController@getCities')->name('getCities');
        // تقرير الاعبين
        Route::get('report/players', 'HomeController@players')->name('reportPlayers');
        //تقرير المبيعات
        Route::get('report/sales', 'HomeController@sales')->name('reportSales');
        // تقرير الخريطة
        Route::get('map/{lat?}/{lng?}', 'HomeController@mapCampaign')->name('getMapCampaign');
        // الصفحة الرئسية للشركات و و اضاقة شركة وتعديلها و حذفها
        Route::resource('companies', 'CompanyController');
        // جدول الشركات
        Route::get('CompanyDatable', 'CompanyController@CompanyDatable')->name('CompanyDatable');

        // مرفقات العلامة التجارية
        Route::get('brand/attachments/{id?}', 'AttachmentsController@indexBrand')->name('indexBrandAttachments');
        // عرض مرفقات العلامة التجارية مع امكانية تعديلها
        Route::get('brand/attachments/{id?}/edit', 'AttachmentsController@editBrand')->name('editBrandAttachments');
        // حفظ التعديلات على مرفقات الشركة
        Route::post('brand/attachments/update', 'AttachmentsController@updateBrand')->name('updateBrandAttachments');

        // مرفقات الشركة
        Route::get('company/attachments/{id?}', 'AttachmentsController@index')->name('indexCompanyAttachments');
        // عرض مرفقات الشركة مع امكانية تعديلها
        Route::get('attachments/{id?}/edit', 'AttachmentsController@edit')->name('editCompanyAttachments');
        // حفظ التعديلات على مرفقات الشركة
        Route::post('attachments/update', 'AttachmentsController@update')->name('updateCompanyAttachments');

        // جهات اتصال الشركة
        Route::get('company/contacts/{id?}', 'ContactController@index')->name('indexCompanyContacts');
        // انشاء جهة اتصال
        Route::get('contacts/{id?}/create', 'ContactController@create')->name('createCompanyContacts');
        // حفظ جهة الاتصال
        Route::post('contacts/store', 'ContactController@store')->name('storeCompanyContacts');
        // جدول جهات الاتصال
        Route::get('contactsDatable', 'ContactController@contactsDatable')->name('contactsDatable');
        // حذف جهة الاتصال
        Route::delete('contacts/{id?}', 'ContactController@destroy')->name('destroyCompanyContacts');
        // الصفجة الرئيسية لليوزر و وانشاء و تعديل و حذف
        Route::resource('users', 'UserController');
        //جدول الويوزر
        Route::get('usersDatable', 'UserController@usersDatable')->name('usersDatable');

        // الصفحة الرئيسة للاعبين و انشاء و تعديل و حذف
        Route::resource('players', 'PlayerController');
        // جدول الاعبين
        Route::get('playersDatable', 'PlayerController@playersDatable')->name('playersDatable');
        // اضافة نقاط للاعب
        Route::get('player/{id?}/points', 'PlayerController@addPoints')->name('addPoints');
        // تعديل النقاط
        Route::post('player/pointsUpdate', 'PlayerController@pointsUpdate')->name('pointsUpdate');
        // استبدال النقاط
        Route::get('player/{id?}/replaceBubbles', 'PlayerController@replaceBubbles')->name('replaceBubbles');

        // الصفحة الرئيسة العلامات التجارية و انشاء و تعديل و حذف
        Route::resource('brands', 'BrandController');
        // جدول العلامات التجارية
        Route::get('brandsDatable', 'BrandController@brandsDatable')->name('brandsDatable');

        // الصفحة الرئيسة bulks و انشاء و تعديل و حذف
        Route::resource('bulks', 'BulkController');
        // جدول bulks
        Route::get('bulksDatable', 'BulkController@bulksDatable')->name('bulksDatable');

        /*Route::resource('employees', 'EmployeeController');
        Route::get('employeesDatable', 'EmployeeController@employeesDatable')->name('employeesDatable');*/
        // الصفحة الرئسية levels و انشاء و تعديل و حذف
        Route::resource('levels', 'levelController');
        // جدول levels
        Route::get('levelsDatable', 'levelController@levelsDatable')->name('levelsDatable');

        // الصفحة الرئسية tanks و انشاء و تعديل و حذف
        Route::resource('tanks', 'TankController');
        // جدول tanks
        Route::get('tanksDatable', 'TankController@tanksDatable')->name('tanksDatable');

        // الصفحة الرئسية packages و انشاء و تعديل و حذف
        Route::resource('packages', 'PackageController');
        // جدول packages
        Route::get('packagesDatable', 'PackageController@packagesDatable')->name('packagesDatable');

        // عرض packages لل brand
        Route::get('brand/packages/{id?}', 'CompanyPackagesController@indexBrandPackages')->name('indexBrandPackages');
        // انشاء  packages لل brand
        Route::get('packages/{id?}/create', 'CompanyPackagesController@createBrandPackages')->name('createBrandPackages');
        // حفظ  packages لل brand
        Route::post('packages/store', 'CompanyPackagesController@storeBrandPackages')->name('storeBrandPackages');
        // جدول  packages لل brand
        Route::get('companyPackagesDatable', 'CompanyPackagesController@companyPackagesDatable')->name('companyPackagesDatable');
        // حذف  packages لل brand
        Route::delete('brand/packages/{id?}', 'CompanyPackagesController@destroyBrandPackages')->name('destroyBrandPackages');

        // عرض الصفحة الرئسية لل campaigns
        Route::resource('campaigns', 'CampaignController')->except(['index', 'create']);
        // عرض campaign
        Route::get('campaigns/{brand_id?}/{package_id?}', 'CampaignController@index')->name('BrandCampaigns');
        // انشاء  campaigns
        Route::get('campaign/{id?}/{package_id?}/create', 'CampaignController@create')->name('campaignCreate');
        // جدول  campaigns
        Route::get('campaignsDatable', 'CampaignController@campaignsDatable')->name('campaignsDatable');

        // عرض الصفحة الرئسية gifts
        Route::get('gifts/{id?}', 'GiftController@index')->name('indexGifts');
        // انشاء gifts
        Route::get('gifts/create/{campaign_id?}', 'GiftController@create')->name('createGifts');
        // تعديل و حذف gifts
        Route::resource('gifts', 'GiftController')->except(['index' ,'create']);
        // جدول gifts
        Route::get('giftsDatable', 'GiftController@giftsDatable')->name('giftsDatable');


        // الصفحة الرئسية countries و انشاء و تعديل و حذف
        Route::resource('countries', 'CountryController');
        // جدول countries
        Route::get('countriesDatable', 'CountryController@countriesDatable')->name('countriesDatable');
        // تغير حالة countries
        Route::get('country/status/{id?}', 'CountryController@statusChange')->name('statusChange');

        // الصفحة الرئسية roles و انشاء و تعديل و حذف
        Route::resource('roles', 'RoleController');
        // جدول rolesDatable
        Route::get('rolesDatable', 'RoleController@rolesDatable')->name('rolesDatable');

       /*********************************************************logs********************************************/
        // الصفحة الرئسية bubblesProcesses
        Route::resource('bubblesProcesses', 'BubblesProcessesController')->except(['show', 'create','store','update','edit','destroy']);
        // جدول bubblesProcesses
        Route::get('bubblesProcessesDatable', 'BubblesProcessesController@bubblesProcessesDatable')->name('bubblesProcessesDatable');

        // الصفحة الرئسية bubblesTransferActions
        Route::resource('bubblesTransferActions', 'BubblesTransferActionsController')->except(['show', 'create','store','update','edit','destroy']);
        // جدول bubblesTransferActions
        Route::get('bubblesTransferActionsDatable', 'BubblesTransferActionsController@bubblesTransferActionsDatable')->name('bubblesTransferActionsDatable');

        // الصفحة الرئسية logUsers
        Route::resource('logUsers', 'LogUsersController')->except(['show', 'create','store','update','edit','destroy']);
        // جدول logUsers
        Route::get('logUsersDatable', 'LogUsersController@logUsersDatable')->name('logUsersDatable');

        // الصفحة الرئسية logCampaigns
        Route::resource('logCampaigns', 'LogCampaignsController')->except(['show', 'create','store','update','edit','destroy']);
        // الصفحة الرئسية logUsers
        Route::get('LogCampaignsDatable', 'LogCampaignsController@logCampaignsDatable')->name('LogCampaignsDatable');

    });


    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/reset/password/{token?}', 'HomeController@resetPassword')->name('resetPassword');
});
