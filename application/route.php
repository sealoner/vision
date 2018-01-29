<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
use think\Route;

Route::get('api/admin/article/:id', 'api/admin/getArticleInfo');

Route::get('api/:vision/banner/:id', 'api/:vision.Banner/getBanner');

Route::group('api/:vision/theme', function(){
    Route::get('','api/:vision.Theme/getSimpleList');//获取主题的简要信息
    Route::get('/:id', 'api/:vision.Theme/getComplexOne');//获取具体的某个主题下的详细信息
});

//路由分组
Route::group('api/:vision/product', function(){
    Route::get('/by_category/:id', 'api/:vision.Product/getAllProductInCategory');//根据商品ID获取当前分类下的商品信息
    Route::get('/:id', 'api/:vision.Product/getOne', [], ['id'=>'\d+']);//根据ID获取商品详情
    Route::get('/count', 'api/:vision.Product/getRecent');//根据前台出来的显示的数量，获取最新商品排序
});

//全部分类信息
Route::get('api/:vision/category/all', 'api/:vision.Category/getAllCategories');

//获取Token令牌
Route::post('api/:vision/token/user', 'api/:vision.Token/getToken');

Route::post('indexInfo/indexInfo/adminInfon', 'api/Index/index');


//地址信息路由
//提交数据用post
Route::post('api/:vision/address', 'api/:vision.Address/createOrUpdateAddress');


//订单路由
Route::group('api/:vision/order', function(){
    Route::post('', 'api/:vision.Order/placeOrder');
});


