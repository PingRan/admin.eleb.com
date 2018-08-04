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
//商家分类路由
Route::resource('shopcategories','ShopCategoryController')->middleware(['role:商家管理员|超级管理员|管理员']);
//修改菜品显示或隐藏
Route::get('updateSelected/{category}','ShopCategoryController@updateSelected')->name('updateSelected')->middleware(['role:商家管理员|超级管理员|管理员']);
//////商家信息
Route::resource('shops','ShopController');
Route::resource('users','UserController')->middleware(['role:商家管理员|超级管理员|管理员|审核员']);

Route::get('addshop/{id}','ShopController@addshop')->name('addshop')->middleware(['role:商家管理员|超级管理员|管理员']);

Route::post('addshop/{id}','ShopController@saveshop')->name('saveshop')->middleware(['role:商家管理员|超级管理员|管理员']);

Route::get('audit/{shop}/{status}','AuditController@audit')->name('audit.update')->middleware(['role:审核员|超级管理员|管理员']);

Route::resource('admins','AdminController')->middleware(['role:超级管理员']);

Route::get('updatestatus/{user}','UserController@updatestatus')->name('update.status')->middleware(['role:审核员|超级管理员|管理员']);

Route::get('login','AdminLoginController@index')->name('login');

Route::post('adminlogin','AdminLoginController@check')->name('adminlogin');

Route::get('loginout','AdminLoginController@loginout')->name('loginout');

Route::get('resetpass','UserController@resetpass')->name('resetpass')->middleware(['role:超级管理员|管理员|商家管理员']);

Route::get('resetname','UserController@resetname')->name('resetname')->middleware(['role:超级管理员|管理员|商家管理员']);

Route::post('resetpass/{user}','UserController@resetpassword')->name('resetpassword')->middleware(['role:超级管理员|管理员|商家管理员']);

Route::resource('activities','ActivityController')->middleware(['role:超级管理员|管理员|活动负责人']);

Route::get('showall/{id}','ShopController@showall')->name('showall')->middleware(['role:超级管理员|管理员|商家管理员']);

Route::post('uploader',function(){
    $store=\Illuminate\Support\Facades\Storage::disk('oss');
    $fileName=$store->putFile('elebran/upload',request()->file('file'));
    $fileurl=$store->url($fileName);
    return ['fileurl'=>$fileurl];
})->name('uploader')->middleware(['role:超级管理员|管理员|活动负责人|商家管理员']);

Route::resource('members','MemberController')->middleware(['role:超级管理员|管理员|会员管理|审核员']);
//修改会员状态
Route::get('editstatus/{member}/{status}','MemberController@editstatus')->name('editstatus')->middleware(['role:超级管理员|管理员|审核员']);

Route::resource('addresses','AddressController')->middleware(['role:超级管理员|管理员|统计员']);
//平台订单页面
Route::get('order','OrderController@index')->name('order.index')->middleware(['role:超级管理员|管理员|统计员']);;
//平台端订单统计
Route::get('orderCount','OrderController@orderCount')->name('orderCount')->middleware(['role:超级管理员|管理员|统计员']);
//菜品统计
Route::get('menuCount','OrderController@menuCount')->name('menuCount')->middleware(['role:超级管理员|管理员|统计员']);
//整体统计
Route::get('overall','OrderController@overall')->name('overall')->middleware(['role:超级管理员|管理员|统计员']);
//Permission权限
Route::resource('permissions','PermissionController')->middleware(['role:超级管理员']);
//角色
Route::resource('roles','RoleController')->middleware(['role:超级管理员']);
//修改管理员的角色
Route::get('editAdminRole/{admin}','AdminController@editAdminRole')->name('editAdminRole')->middleware(['role:超级管理员']);
//保存管理员角色
Route::post('saveAdminRole/{admin}','AdminController@saveAdminRole')->name('saveAdminRole')->middleware(['role:超级管理员']);
//菜单管理
Route::resource('navs','NavController')->middleware(['role:超级管理员']);
//抽奖活动
Route::resource('events','EventController')->middleware(['role:超级管理员|管理员|活动负责人']);
//抽奖奖品
Route::resource('eventPrizes','EventPrizeController')->middleware(['role:超级管理员|管理员|活动负责人']);
//抽奖奖品
Route::get('prizeList/{event}','EventPrizeController@index')->name('prizeList')->middleware(['role:超级管理员|管理员|活动负责人']);
//报名表
Route::get('eventUsers','EventUserController@index')->middleware(['role:超级管理员|管理员|活动负责人']);
//开奖
Route::get('startLottery/{event}','EventController@startLottery')->name('startLottery')->middleware(['role:超级管理员|管理员|活动负责人']);;
