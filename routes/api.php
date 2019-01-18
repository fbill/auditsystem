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
Route::group(['middleware'=>['auth']],function(){


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('companies', 'CompanyController');

Route::get('getGraphStores/{company_id}', 'CompanyStoreController@getGraphStores');
Route::get('getUbigeosForCampaigne/{company_id}', 'CompanyStoreController@getUbigeosForCampaigne');

Route::get('getCategoryPoll/{company_id}/{audit_id}', 'PollController@getCategoryForCompanyAudit');
Route::get('getPollsForCategory/{category_id}/{company_audit_id}', 'PollController@getPollsForCategory');
Route::get('getPollDetailsForPollId/{poll_id}/{type}/{ubigeo?}', 'PollDetailsController@getRegsForPollId');
Route::get('getMenus/{company_id}', 'AuditController@getMenusForCompany');
Route::get('getAudits/{company_id}', 'AuditController@getAuditsForCompany');
Route::get('getCampaignes/{customer_id}/{visible}/{estudio}/{active}', 'CompanyController@getCampaigneForClient');
Route::get('getUsersForType/{type}', 'UserController@getUserForType');
Route::get('getPublicitiesForCategory/{category_id}/{company_id}', 'PublicityController@getPublicitiesForCategory');
Route::post('listStoresPublicities', 'PublicityController@ListStoresPublicity');
Route::post('getBaseForCompanyAudit', 'CompanyStoreController@getBaseForCompanyUbigeoAudit');//solo mistery
Route::get('getStore/{store_id}', 'StoreController@show');
Route::get('getStoreMedia/{store_id}/{company_id}/{poll_id}', 'StoreController@getMediasStore');
Route::get('getProductsPublicity/{company_id}/{publicity_id}', 'StockProductPopController@getProductsForPublicity');