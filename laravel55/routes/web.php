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
//登陆
Route::get('login','LogAndRegiController@login');
//注册
Route::get('register','LogAndRegiController@register');
//产品分类页
Route::get('category','Category\CategoryController@category');
//产品列表页
Route::get('category/child/product/{child_id}','Category\CategoryController@product');
//产品详情页
Route::get('category/child/pdt_content/{product_id}','Category\CategoryController@pdtContent');
//购物车添加功能
Route::get('service/addCart/{product_id}','Service\BookcartController@addCart');
Route::get('service/onDelect','Service\BookcartController@onDelect');
//购物车页
Route::get('view/cart','view\CartController@toCart');

//中间件
Route::group(['middleware'=>'check.login'],function(){
  //付款链接
  Route::post('view/toCommit','view\CartController@toCommit');
  //订单列表
  Route::get('view/order_list','view\CartController@orderList');
});


Route::group(['prefix'=>'validate'],function(){
  //验证码路由
  Route::get('validate_code/create','Validate\VerifyController@verify');
  //发送短信路由
  Route::post('validate_code/send','Validate\VerifyController@sendSMS');
  //手机和邮箱验证路由
  Route::post('validate_code/phone','Validate\MemberController@phoneCheck');
  Route::post('validate_code/email','Validate\MemberController@emailCheck');

  //验证注册信息路由
  Route::post('validate_code/register','Validate\MemberController@registerCheck');
  //登陆验证路由
  Route::post('validate_code/login','Validate\MemberController@loginCheck');
  //邮箱激活验证
  Route::get('validate_email','Validate\VerifyController@validateEmail');

});
//二级分类查询
Route::get('category/child/{category_id}','Category\CategoryController@child');


//Admin
Route::group(['prefix'=>'admin'],function(){

  Route::get('login','Admin\AdminController@toLogin');
  Route::get('index','Admin\AdminController@toIndex');
  Route::get('category','Admin\CategoryController@categoryList');
  Route::post('service/login','Admin\AdminController@checkLogin');
  Route::get('product','Admin\CategoryController@productList');
  Route::get('productAdd','Admin\AdminController@productAdd');
  Route::any('categoryAdd','Admin\CategoryController@categoryAdd');
  Route::post('service/addcategory','Admin\Service\SqlController@addcategory');
  Route::post('service/del','Admin\Service\SqlController@del');
  Route::any('categoryEdit','Admin\Service\SqlController@categoryEdit');
  Route::post('service/edit_category','Admin\Service\SqlController@editCategory');
  Route::any('service/uploadImages/{images}','Admin\Service\UploadController@uploadImages');
  Route::any('service/product_add','Admin\Service\SqlController@productadd');
  Route::post('service/product_del','Admin\Service\SqlController@productDel');
  Route::get('service/product_edit','Admin\CategoryController@productEdit');
  Route::post('service/edit_product','Admin\Service\SqlController@editProduct');

});
