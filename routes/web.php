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

Route::get('/', function () {
    return redirect(app()->getLocale());
});
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'], function () {

    Route::group(['middleware' => ['auth']], function () {

        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('getCities/{country_id?}', 'HomeController@getCities')->name('getCities');
        Route::get('report/players', 'HomeController@players')->name('reportPlayers');
        Route::get('report/sales', 'HomeController@sales')->name('reportSales');

        Route::resource('companies', 'CompanyController');
        Route::get('CompanyDatable', 'CompanyController@CompanyDatable')->name('CompanyDatable');


        Route::get('brand/attachments/{id?}', 'AttachmentsController@indexBrand')->name('indexBrandAttachments');
        Route::get('brand/attachments/{id?}/edit', 'AttachmentsController@editBrand')->name('editBrandAttachments');
        Route::post('brand/attachments/update', 'AttachmentsController@updateBrand')->name('updateBrandAttachments');

        Route::get('company/attachments/{id?}', 'AttachmentsController@index')->name('indexCompanyAttachments');
        Route::get('attachments/{id?}/edit', 'AttachmentsController@edit')->name('editCompanyAttachments');
        Route::post('attachments/update', 'AttachmentsController@update')->name('updateCompanyAttachments');

        Route::get('company/contacts/{id?}', 'ContactController@index')->name('indexCompanyContacts');
        Route::get('contacts/{id?}/create', 'ContactController@create')->name('createCompanyContacts');
        Route::post('contacts/store', 'ContactController@store')->name('storeCompanyContacts');
        Route::get('contactsDatable', 'ContactController@contactsDatable')->name('contactsDatable');
        Route::delete('contacts/{id?}', 'ContactController@destroy')->name('destroyCompanyContacts');

        Route::resource('users', 'UserController');
        Route::get('usersDatable', 'UserController@usersDatable')->name('usersDatable');

        Route::resource('players', 'PlayerController');
        Route::get('playersDatable', 'PlayerController@playersDatable')->name('playersDatable');
        Route::get('player/{id?}/points', 'PlayerController@addPoints')->name('addPoints');
        Route::post('player/pointsUpdate', 'PlayerController@pointsUpdate')->name('pointsUpdate');

        Route::resource('brands', 'BrandController');
        Route::get('brandsDatable', 'BrandController@brandsDatable')->name('brandsDatable');

        Route::resource('bulks', 'BulkController');
        Route::get('bulksDatable', 'BulkController@bulksDatable')->name('bulksDatable');

        Route::resource('employees', 'EmployeeController');
        Route::get('employeesDatable', 'EmployeeController@employeesDatable')->name('employeesDatable');

        Route::resource('levels', 'levelController');
        Route::get('levelsDatable', 'levelController@levelsDatable')->name('levelsDatable');

        Route::resource('tanks', 'TankController');
        Route::get('tanksDatable', 'TankController@tanksDatable')->name('tanksDatable');

        Route::resource('packages', 'PackageController');
        Route::get('packagesDatable', 'PackageController@packagesDatable')->name('packagesDatable');

        Route::get('brand/packages/{id?}', 'CompanyPackagesController@indexBrandPackages')->name('indexBrandPackages');
        Route::get('packages/{id?}/create', 'CompanyPackagesController@createBrandPackages')->name('createBrandPackages');
        Route::post('packages/store', 'CompanyPackagesController@storeBrandPackages')->name('storeBrandPackages');
        Route::get('companyPackagesDatable', 'CompanyPackagesController@companyPackagesDatable')->name('companyPackagesDatable');
        Route::delete('brand/packages/{id?}', 'CompanyPackagesController@destroyBrandPackages')->name('destroyBrandPackages');

        Route::resource('campaigns', 'CampaignController')->except(['index', 'create']);
        Route::get('campaigns/{brand_id?}/{package_id?}', 'CampaignController@index')->name('BrandCampaigns');
        Route::get('campaign/{id?}/{package_id?}/create', 'CampaignController@create')->name('campaignCreate');
        Route::get('campaignsDatable', 'CampaignController@campaignsDatable')->name('campaignsDatable');

        Route::get('gifts/{id?}', 'GiftController@index')->name('indexGifts');
        Route::get('gifts/create/{campaign_id?}', 'GiftController@create')->name('createGifts');
        Route::resource('gifts', 'GiftController')->except(['index' ,'create']);
        Route::get('giftsDatable', 'GiftController@giftsDatable')->name('giftsDatable');


        Route::resource('countries', 'CountryController');
        Route::get('countriesDatable', 'CountryController@countriesDatable')->name('countriesDatable');


       /*********************************************************logs********************************************/
        Route::resource('bubblesProcesses', 'BubblesProcessesController')->except(['show', 'create','store','update','edit','destroy']);
        Route::get('bubblesProcessesDatable', 'BubblesProcessesController@bubblesProcessesDatable')->name('bubblesProcessesDatable');

        Route::resource('bubblesTransferActions', 'BubblesTransferActionsController')->except(['show', 'create','store','update','edit','destroy']);
        Route::get('bubblesTransferActionsDatable', 'BubblesTransferActionsController@bubblesTransferActionsDatable')->name('bubblesTransferActionsDatable');

        Route::resource('logUsers', 'LogUsersController')->except(['show', 'create','store','update','edit','destroy']);
        Route::get('logUsersDatable', 'LogUsersController@logUsersDatable')->name('logUsersDatable');

        Route::resource('logCampaigns', 'LogCampaignsController')->except(['show', 'create','store','update','edit','destroy']);
        Route::get('LogCampaignsDatable', 'LogCampaignsController@logCampaignsDatable')->name('LogCampaignsDatable');

    });


    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/reset/password/{token?}', 'HomeController@resetPassword')->name('resetPassword');
});