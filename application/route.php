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
use \think\Route;
//兼容模式 不支持伪静态可开启
//\think\Url::root('index.php?s=');
Route::group('admin',function(){
//    Route::rule('/index2','admin/Index/index2','get');
//    Route::controller('index','admin/Index');
//    resource('system_menus','SystemMenus');
//    Route::rule('/menus','SystemMenus','get');
//    Route::resource('menus','admin/SystemMenus',['var'=>['menus'=>'menu_id']]);
//    Route::miss(function(){
//        return '页面不存在!';
//    });
});


Route::group('index',function(){
//    Route::rule('/index2','admin/Index/index2','get');
  //  Route::controller('index','index/test');
//    resource('system_menus','SystemMenus');
//    Route::rule('/menus','SystemMenus','get');
//    Route::resource('menus','admin/SystemMenus',['var'=>['menus'=>'menu_id']]);
//    Route::miss(function(){
//        return '页面不存在!';
//    });
});



//登录
Route::post('api/:ver/login', 'api/:ver.login/index');  //登录接口
Route::post('api/:ver/smscode', 'api/:ver.smscode/sendcode');  //获取验证码接口



//首页
Route::get('api/:ver/home/baner', 'api/:ver.home/baner');  //首页baner
Route::get('api/:ver/home/cat', 'api/:ver.home/cat');  //首页分类
Route::get('api/:ver/home/adpic', 'api/:ver.home/adpic');  //首页广告
Route::get('api/:ver/home/goodhot', 'api/:ver.home/goodhot');  //首页热销商品
Route::get('api/:ver/home/goodbest', 'api/:ver.home/goodbest');  //首页推荐商品
Route::get('api/:ver/home/catgood', 'api/:ver.home/catgood');  //   三级页面分类下的商品
Route::get('api/:ver/home/getrandgood', 'api/:ver.home/getrandgood');  //   随机推荐商品
Route::get('api/:ver/home/hotsearch', 'api/:ver.home/hotsearch');  //   热门商品搜索关键字



//商品列表
Route::get('api/:ver/goodlist/lists', 'api/:ver.goodlist/lists');  // 商品列表




Route::post('api/:ver/goodcar/joincar', 'api/:ver.goodcar/joincar');  //加入购物车
Route::post('api/:ver/goodcar/changecartnum', 'api/:ver.goodcar/changecartnum');  //修改购物车数量
Route::post('api/:ver/goodcar/removecart', 'api/:ver.goodcar/removecart');  //删除购物车数量
Route::get('api/:ver/goodcar/getcartnum', 'api/:ver.goodcar/getcartnum');  //获取购物车数量
Route::get('api/:ver/goodcar/getcartlist', 'api/:ver.goodcar/getcartlist');  //获取购物车列表


//收藏
Route::post('api/:ver/collect/collectproduct', 'api/:ver.collect/collectproduct');  //添加商品收藏
Route::post('api/:ver/collect/uncollectproduct', 'api/:ver.collect/uncollectproduct');  //取消商品收藏
Route::get('api/:ver/collect/getusercollectproduct', 'api/:ver.collect/getusercollectproduct');  //商品收藏列表
Route::post('api/:ver/collect/vedioimgcollect', 'api/:ver.collect/vedioimgcollect');   //视频图片收藏
Route::get('api/:ver/collect/vedioimgcollectlist', 'api/:ver.collect/vedioimgcollectlist'); //视频图片收藏列表
Route::post('api/:ver/collect/vedioimgcollectdel', 'api/:ver.collect/vedioimgcollectdel');   //批量取消视频图片收藏

//地址
Route::post('api/:ver/address/edituseraddress', 'api/:ver.address/edituseraddress');  //添加修改地址
Route::get('api/:ver/address/userdefaultaddress', 'api/:ver.address/userdefaultaddress');  //获取用户默认收货地址   SetUserDefaultAddress
Route::post('api/:ver/address/setuserdefaultaddress', 'api/:ver.address/setuserdefaultaddress');  //设置地址为默认地址
Route::post('api/:ver/address/removeuseraddress', 'api/:ver.address/removeuseraddress');  //删除收货地址
Route::get('api/:ver/address/useraddresslist', 'api/:ver.address/useraddresslist');  //获取用户所有地址

//订单
Route::get('api/:ver/order/getuserorderlist', 'api/:ver.order/getuserorderlist');  //订单列表  CreateOrder
Route::post('api/:ver/order/confirmorder', 'api/:ver.order/confirmorder');  //单个下单商品订单页面
Route::post('api/:ver/order/goodcarconfirmorder', 'api/:ver.order/goodcarconfirmorder');  //购物车下单商品订单页面
Route::post('api/:ver/order/createorderpay', 'api/:ver.order/createorderpay');  //下单支付
Route::get('api/:ver/order/getorder', 'api/:ver.order/getorder'); //订单详情
Route::get('api/:ver/order/usertakeorder', 'api/:ver.order/usertakeorder'); //确认收货
Route::post('api/:ver/order/usercommentproduct', 'api/:ver.order/usercommentproduct'); //订单评价
Route::post('api/:ver/order/applyorderrefund', 'api/:ver.order/applyorderrefund'); //申请退款


//Route::get('api/:ver/order/getorder', 'api/:ver.order/getorder'); //订单详情
////Route::get('api/:ver/order/usertakeorder', 'api/:ver.order/usertakeorder'); //确认收货  UserCommentProduct
//Route::post('api/:ver/order/usercommentproduct', 'api/:ver.order/usercommentproduct'); //订单评价




//商品
Route::get('api/:ver/good/details', 'api/:ver.good/details'); //商品详情
Route::get('api/:ver/good/productattrdetail', 'api/:ver.good/productattrdetail');  //商品属性
Route::get('api/:ver/good/productreplylist', 'api/:ver.good/productreplylist');  //商品评论列表
Route::get('api/:ver/good/productattrdetailandroid', 'api/:ver.good/productattrdetailandroid');  //商品属性测试


//3d
Route::get('api/:ver/vedio/lists', 'api/:ver.vedio/lists'); //视频图片列表
Route::get('api/:ver/vedio/details', 'api/:ver.vedio/details'); //视频图片详情


//设置
Route::get('api/:ver/setting/lists', 'api/:ver.setting/lists'); //设置页面
Route::post('api/:ver/setting/modname', 'api/:ver.setting/modname'); //修改昵称
Route::post('api/:ver/setting/modtel', 'api/:ver.setting/modtel'); //修改手机号码
Route::post('api/:ver/setting/upload', 'api/:ver.setting/upload'); //上传图片


//我的
Route::get('api/:ver/my/myinfo', 'api/:ver.my/myinfo'); //我的信息




//H5页面
Route::get('api/:ver/good/details', 'api/:ver.good/details'); //  ProductAttrDetail
Route::get('api/:ver/good/productattrdetail', 'api/:ver.good/productattrdetail');
Route::get('api/:ver/good/pay', 'api/:ver.good/pay'); // getCode
Route::get('api/:ver/good/getcode', 'api/:ver.good/getcode'); //
Route::get('api/:ver/good/wxpayurl', 'api/:ver.good/wxpayurl'); //  weixinNotify

Route::post('api/:ver/good/weixinnotify', 'api/:ver.good/weixinnotify');

Route::get('api/:ver/good/test', 'api/:ver.good/test'); //