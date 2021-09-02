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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::middleware('auth:api')->group(function(){
  // Accessive.id
  // Filter
  Route::get('category_type_default', 'API\FilterGetData@categoryTypeDefault');
  Route::get('search/parameter/{parameter}', 'API\FilterGetData@searchByAll');
  Route::get('filter/parameter/', 'API\FilterGetData@filterByAll');
  Route::get('filter/category/id/{category_id}', 'API\FilterGetData@filterByCategoryId');
  Route::get('filter/category/name/{category_name}', 'API\FilterGetData@filterByCategoryName');
  Route::get('filter/name/{place_name}', 'API\FilterGetData@filterByName');
  Route::get('filter/address/{address_parameter}', 'API\FilterGetData@filterByAddress');
  Route::get('sort/place/desc', 'API\FilterGetData@sortDesc');

  // Place Detail
  Route::get('place/detail/{place_id}', 'API\PlaceController@detailPlace');
  Route::get('place/listfacility/{place_id}', 'API\PlaceController@listFacilityPlace');
  Route::get('place/listguide/{place_id}', 'API\PlaceController@listGuidePlace');
  Route::get('place/detail/guide/{guide_id}', 'API\PlaceController@detailGuidePlace');

  // Collection / Withlist
  Route::get('collection/get/{user_id}', 'API\CollectionController@getCollection');
  Route::post('collection/add', 'API\CollectionController@postCollection');
  Route::post('collection/deleted', 'API\CollectionController@deletedCollection');

  // Modul User
  Route::post('user/update', 'API\UserController@update');
  Route::get('user', 'API\UserController@index');
  Route::get('user/business', 'API\UserController@getBusiness');
  Route::post('user/session', 'API\UserController@setSession');
  
  

});