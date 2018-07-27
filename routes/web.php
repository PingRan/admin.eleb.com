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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('shopcategories','ShopCategoryController');

Route::resource('shops','ShopController');

Route::resource('users','UserController');

Route::get('addshop/{id}','ShopController@addshop')->name('addshop');

Route::post('addshop/{id}','ShopController@saveshop')->name('saveshop');

Route::get('audit/{shop}/{status}','AuditController@audit')->name('audit.update');

Route::resource('admins','AdminController');

Route::get('updatestatus/{user}/{status}','UserController@updatestatus')->name('update.status');

Route::get('login','AdminLoginController@index')->name('login');

Route::post('adminlogin','AdminLoginController@check')->name('adminlogin');

Route::get('loginout','AdminLoginController@loginout')->name('loginout');

Route::get('resetpass','UserController@resetpass')->name('resetpass');

Route::get('resetname','UserController@resetname')->name('resetname');

Route::post('resetpass/{user}','UserController@resetpassword')->name('resetpassword');

Route::resource('activities','ActivityController');

Route::get('showall/{id}','ShopController@showall')->name('showall');

Route::post('uploader',function(){
    $store=\Illuminate\Support\Facades\Storage::disk('oss');
    $fileName=$store->putFile('elebran/upload',request()->file('file'));
    $fileurl=$store->url($fileName);
    return ['fileurl'=>$fileurl];
})->name('uploader');

Route::resource('members','MemberController');
Route::resource('addresses','AddressController');