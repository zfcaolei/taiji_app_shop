<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:85:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\agent\agent_manage\index.php";i:1556184114;s:77:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\container.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\inner_page.php";i:1556184114;s:80:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_footer.php";i:1556184114;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(empty($is_layui) || (($is_layui instanceof \think\Collection || $is_layui instanceof \think\Paginator ) && $is_layui->isEmpty())): ?>
    <link href="/public/system/frame/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <?php endif; ?>
    <link href="/public/static/plug/layui/css/layui.css" rel="stylesheet">
    <link href="/public/system/css/layui-admin.css" rel="stylesheet"></link>
    <link href="/public/system/frame/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">
    <link href="/public/system/frame/css/animate.min.css" rel="stylesheet">
    <link href="/public/system/frame/css/style.min.css?v=3.0.0" rel="stylesheet">
    <script src="/public/system/frame/js/jquery.min.js"></script>
    <script src="/public/system/frame/js/bootstrap.min.js"></script>
    <script src="/public/static/plug/layui/layui.all.js"></script>
    <script>
        $eb = parent._mpApi;
        // if(!$eb) top.location.reload();
        window.controlle="<?php echo strtolower(trim(preg_replace("/[A-Z]/", "_\\0", think\Request::instance()->controller()), "_"));?>";
        window.module="<?php echo think\Request::instance()->module();?>";
    </script>



    <title></title>
    
<link href="/public/system/frame/css/plugins/iCheck/custom.css" rel="stylesheet">
<script src="/public/static/plug/moment.js"></script>
<link rel="stylesheet" href="/public/static/plug/daterangepicker/daterangepicker.css">
<script src="/public/static/plug/daterangepicker/daterangepicker.js"></script>
<script src="/public/system/frame/js/plugins/iCheck/icheck.min.js"></script>
<link href="/public/system/frame/css/plugins/footable/footable.core.css" rel="stylesheet">
<script src="/public/static/plug/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/public/system/frame/js/plugins/footable/footable.all.min.js"></script>
<script src="/public/system/js/layuiList.js"></script>
<style>
    .on-tag{background-color: #eea91e;}
    .height-auto{height: 300px;}
    .tag{border: solid 1px #eee;}
</style>

    <!--<script type="text/javascript" src="/static/plug/basket.js"></script>-->
<script type="text/javascript" src="/public/static/plug/requirejs/require.js"></script>
<?php /*  <script type="text/javascript" src="/static/plug/requirejs/require-basket-load.js"></script>  */ ?>
<script>
    var hostname = location.hostname;
    if(location.port) hostname += ':' + location.port;
    requirejs.config({
        map: {
            '*': {
                'css': '/public/static/plug/requirejs/require-css.js'
            }
        },
        shim:{
            'iview':{
                deps:['css!iviewcss']
            },
            'layer':{
                deps:['css!layercss']
            }
        },
        baseUrl:'//'+hostname+'/public/',
        paths: {
            'static':'static',
            'system':'system',
            'vue':'static/plug/vue/dist/vue.min',
            'axios':'static/plug/axios.min',
            'iview':'static/plug/iview/dist/iview.min',
            'iviewcss':'static/plug/iview/dist/styles/iview',
            'lodash':'static/plug/lodash',
            'layer':'static/plug/layer/layer',
            'layercss':'static/plug/layer/theme/default/layer',
            'jquery':'static/plug/jquery/jquery.min',
            'moment':'static/plug/moment',
            'sweetalert':'static/plug/sweetalert2/sweetalert2.all.min'

        },
        basket: {
            excludes:['system/js/index','system/util/mpVueComponent','system/util/mpVuePackage']
//            excludes:['system/util/mpFormBuilder','system/js/index','system/util/mpVueComponent','system/util/mpVuePackage']
        }
    });
</script>
<script type="text/javascript" src="/public/system/util/mpFrame.js"></script>
    
</head>
<body class="gray-bg">
<!--演示地址https://daneden.github.io/animate.css/?-->
<div class="wrapper wrapper-content animated ">

<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <!--<div class="ibox-title">
                <button type="button" class="btn btn-w-m btn-primary grant">发放优惠券</button>
                <button type="button" class="btn btn-w-m btn-primary" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('store.storeCoupon/grant_subscribe'); ?>',{'w':800})">给关注的用户发放优惠券</button>
                <button type="button" class="btn btn-w-m btn-primary" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('store.storeCoupon/grant_all'); ?>',{'w':800})">给所有用户发放优惠券</button>
                <button type="button" class="btn btn-w-m btn-primary" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('store.storeCoupon/grant_group'); ?>',{'w':800})">给分组用户发放优惠券</button>
                <button type="button" class="btn btn-w-m btn-primary" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('store.storeCoupon/grant_tag'); ?>',{'w':800})">给标签用户发放优惠券</button>
            </div>-->
            <div class="ibox-content">
                <div class="row">
                    <div class="m-b m-l">
                        <form action="" class="form-inline" id="form" method="get">

                            <div class="search-item" data-name="data">
                                <span>选择时间：</span>
                                <button type="button" class="btn btn-outline btn-link" data-value="">全部</button>
                                <button type="button" class="btn btn-outline btn-link" data-value="<?php echo $limitTimeList['today']; ?>">今天</button>
                                <button type="button" class="btn btn-outline btn-link" data-value="<?php echo $limitTimeList['week']; ?>">本周</button>
                                <button type="button" class="btn btn-outline btn-link" data-value="<?php echo $limitTimeList['month']; ?>">本月</button>
                                <button type="button" class="btn btn-outline btn-link" data-value="<?php echo $limitTimeList['quarter']; ?>">本季度</button>
                                <button type="button" class="btn btn-outline btn-link" data-value="<?php echo $limitTimeList['year']; ?>">本年</button>
                                <div class="datepicker" style="display: inline-block;">
                                    <button type="button" class="btn btn-outline btn-link" data-value="<?php echo !empty($where['data'])?$where['data']:'no'; ?>">自定义时间</button>
                                </div>
                                <input class="search-item-value" type="hidden" name="data" value="<?php echo $where['data']; ?>" />
                                <input class="search-item-value" type="hidden" name="groupid" value="<?php echo $where['groupid']; ?>" />
                                <input class="search-item-value" type="hidden" name="tagid_list" value="<?php echo $where['tagid_list']; ?>" />
                                <input class="search-item-value" type="hidden" name="sex" value="<?php echo $where['sex']; ?>" />
                                <input class="search-item-value" type="hidden" name="subscribe" value="<?php echo $where['subscribe']; ?>" />
                                <input class="search-item-value" type="hidden" name="stair" value="" />
                                <input class="search-item-value" type="hidden" name="second" value="" />
                                <input class="search-item-value" type="hidden" name="order_stair" value="" />
                                <input class="search-item-value" type="hidden" name="order_second" value="" />
                                <input class="search-item-value" type="hidden" name="now_money" value="" />
                                <input class="search-item-value" type="hidden" id="batch" name="batch" value="" />
                            </div>
                            <hr>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="padding: 5px 15px;"
                                        aria-expanded="false">批量操作
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu left">
                                    <li>
                                        <a class="save_mark grant" href="javascript:void(0);"  >
                                            <i class="fa fa-space-shuttle"></i> 发放优惠券
                                        </a>
                                    </li>
                                    <li>
                                        <a class="save_mark news" href="javascript:void(0);"  >
                                            <i class="fa fa-space-shuttle"></i> 发送消息
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="input-group" style="float: right">
                                <input type="text" name="nickname" value="<?php echo $where['nickname']; ?>" placeholder="请输入会员名称" class="input-sm form-control">

                                <input type="hidden" name="export" value="<?php echo $where['export']; ?>" />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary" id="search"> <i class="fa fa-search"></i>搜索</button>
                                    <button style="margin: 0 16px" type="submit" id="export" class="btn btn-sm btn-info btn-outline"> <i class="fa fa-exchange" ></i> Excel导出</button>
                                    <script>
                                        $('#export').on('click',function(){
                                            $('input[name=export]').val(1);
                                        });
                                        $('#no_export').on('click',function(){
                                            $('input[name=export]').val(0);
                                        });
                                        $('#search').on('click',function(){
                                            $('input[name=export]').val(0);
                                        });
                                    </script>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped  table-bordered"  data-page-size="20">
                        <thead>
                            <tr>
                                <th class="text-cente">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">
                                            选择
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu left">
                                            <li class="this-page">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-check-square-o"></i>本页用户
                                                </a>
                                            </li>
                                            <li class="this-all">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-check-square"></i>全部用户
                                                </a>
                                            </li>
                                            <li class="this-up">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-square-o"></i>取消选择
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">编号</th>
                                <th class="text-center">微信用户名称</th>
                                <th class="text-center">头像</th>
                                <th class="text-center">用户类型</th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">性别
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="sex">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-venus-mars"></i>全部
                                                </a>
                                            </li>
                                            <li data-value="1">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-mars"></i>男
                                                </a>
                                            </li>
                                            <li data-value="2">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-venus"></i>女
                                                </a>
                                            </li>
                                            <li data-value="0">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-transgender"></i>保密
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center no-sort">地区</th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">一级推荐人
                                            <span class="stair caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="stair">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-arrows-v"></i>默认
                                                </a>
                                            </li>
                                            <li data-value="stair desc">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-sort-numeric-desc"></i>降序
                                                </a>
                                            </li>
                                            <li data-value="stair asc">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-sort-numeric-asc"></i>升序
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">二级推荐人
                                            <span class="second caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="second">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-arrows-v"></i>默认
                                                </a>
                                            </li>
                                            <li data-value="second desc">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-sort-numeric-desc"></i>降序
                                                </a>
                                            </li>
                                            <li data-value="second asc">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-sort-numeric-asc"></i>升序
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">一级推广订单
                                            <span class="order_stair caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="order_stair">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-arrows-v"></i>默认
                                                </a>
                                            </li>
                                            <li data-value="order_stair desc">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-sort-numeric-desc"></i>降序
                                                </a>
                                            </li>
                                            <li data-value="order_stair asc">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-sort-numeric-asc"></i>升序
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">所有推广订单
                                            <span class="caret order_second"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="order_second">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-arrows-v"></i>默认
                                                </a>
                                            </li>
                                            <li data-value="order_second desc">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-sort-numeric-asc"></i>降序
                                                </a>
                                            </li>
                                            <li data-value="order_second asc">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-sort-numeric-desc"></i>升序
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">获得佣金
                                            <span class="now_money caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="now_money">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-arrows-v"></i>默认
                                                </a>
                                            </li>
                                            <li data-value="now_money desc">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    <i class="fa fa-sort-numeric-asc"></i>降序
                                                </a>
                                            </li>
                                            <li data-value="now_money asc">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    <i class="fa fa-sort-numeric-desc"></i>升序
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-white btn-xs dropdown-toggle" style="font-weight: bold;background-color: #f5f5f6;border: solid 0;"
                                                aria-expanded="false">是否关注公众号
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-item" data-name="subscribe">
                                            <li data-value="">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    全部
                                                </a>
                                            </li>
                                            <li data-value="1">
                                                <a class="save_mark" href="javascript:void(0);"  >
                                                    关注
                                                </a>
                                            </li>
                                            <li data-value="0">
                                                <a class="save_mark" href="javascript:void(0);">
                                                    未关注
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th class="text-center">推广二维码</th>
                                <th class="text-center">累计提现金额</th>
                                <th class="text-center">可提现金额</th>
                                <th class="text-center">提现次数</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php $count = count($list); if($count): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                    <td class="text-center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="coupon[]" value="<?php echo $vo['uid']; ?>">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['uid']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['nickname']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img src="<?php echo $vo['headimgurl']; ?>" alt="<?php echo $vo['nickname']; ?>" title="<?php echo $vo['nickname']; ?>" style="width:50px;height: 50px;cursor: pointer;" class="head_image" data-image="<?php echo $vo['headimgurl']; ?>">
                                    </td>
                                        <td class="text-center">
                                            <?php if($vo['user_type'] == 'routine'): ?>
                                                小程序授权
                                            <?php else: ?>
                                                公众号授权
                                            <?php endif; ?>
                                        </td>
                                    <td class="text-center">
                                        <?php if($vo['sex'] == 1): ?>
                                        男
                                        <?php elseif($vo['sex'] == 2): ?>
                                        女
                                        <?php else: ?>
                                        保密
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['country']; ?><?php echo $vo['province']; ?><?php echo $vo['city']; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-white  btn-xs"  onclick="$eb.createModalFrame('推荐人列表','<?php echo Url('stair',['uid'=>$vo['uid']]); ?>',{'w':800})">
                                            <i class="fa fa-street-view"></i>
                                            <?php echo $vo['stair']; ?>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['second']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['order_stair']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['order_second']; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-white  btn-xs"  onclick="$eb.createModalFrame('佣金记录','<?php echo Url('now_money',['uid'=>$vo['uid']]); ?>',{'w':800})">
                                            <i class="fa fa-dollar"></i>
                                            <?php echo $vo['now_money']; ?>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <?php if($vo['subscribe']): ?>
                                        关注
                                        <?php else: ?>
                                        未关注
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($vo['user_type'] == 'routine'): ?>
                                           暂无
                                        <?php else: ?>
                                           <img src="<?php echo $vo['qr_code']['url']; ?>" alt="<?php echo $vo['nickname']; ?>" title="<?php echo $vo['nickname']; ?>" style="width:50px;height: 50px;cursor: pointer;" class="head_image" data-image="<?php echo $vo['qr_code']['url']; ?>">
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['extract_count_price']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['now_money']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $vo['extract_count_num']; ?>
                                    </td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                <tr id="content" style="display:none;height:400px;"></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <link href="/public/system/frame/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" id="DataTables_Table_0_info" role="alert" aria-live="polite" aria-relevant="all">共 <?php echo $total; ?> 项</div>
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
            <?php echo $page; ?>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>



<script>
    window.$list = <?php echo json_encode($list);?>;
    window.$uidAll = <?php echo json_encode($uidAll);?>;
    window.$where = <?php echo json_encode($where);?>;
    $('.this-page').on('click',function () {
        $('input[name="coupon[]"]').each(function(){
            $(this).checked = true;
            $(this).parent().addClass('checked');
            $('#batch').val(1);
        });
    })
    $('.this-all').on('click',function () {
        $('input[name="coupon[]"]').each(function(){
            $(this).checked = true;
            $(this).parent().addClass('checked');
            $('#batch').val(2);
        });
    })
    $('.this-up').on('click',function () {
        $('input[name="coupon[]"]').each(function(){
            $(this).checked = false;
            $(this).parent().removeClass('checked');
            $('#batch').val('');
        });
    })
    $(function init() {
        $('.search-item>.btn').on('click', function () {
            var that = $(this), value = that.data('value'), p = that.parent(), name = p.data('name'), form = p.parents();
            form.find('input[name="' + name + '"]').val(value);
            $('input[name=export]').val(0);
            form.submit();
        });
        $('.tag-item>.btn').on('click', function () {
            var that = $(this), value = that.data('value'), p = that.parent(), name = p.data('name'), form = p.parents(),list = $('input[name="' + name + '"]').val().split(',');
            var bool = 0;
            $.each(list,function (index,item) {
                if(item == value){
                    bool = 1
                    list.splice(index,1);
                }
            })
            if(!bool) list.push(''+value+'');
            form.find('input[name="' + name + '"]').val(list.join(','));
            $('input[name=export]').val(0);
            form.submit();
        });
        $('.search-item>li').on('click', function () {
            var that = $(this), value = that.data('value'), p = that.parent(), name = p.data('name'), form = $('#form');
            form.find('input[name="' + name + '"]').val(value);
            $('input[name=export]').val(0);
            form.submit();
        });
        $('.search-item>li').each(function () {
            var that = $(this), value = that.data('value'), p = that.parent(), name = p.data('name');
            if($where[name]) $('.'+name).css('color','#1ab394');
        });
        $('.search-item-value').each(function () {
            var that = $(this), name = that.attr('name'), value = that.val(), dom = $('.search-item[data-name="' + name + '"] .btn[data-value="' + value + '"]');
            dom.eq(0).removeClass('btn-outline btn-link').addClass('btn-primary btn-sm')
                .siblings().addClass('btn-outline btn-link').removeClass('btn-primary btn-sm')
        });
        $('.tag-item-value').each(function () {
            var that = $(this), name = that.attr('name'), value = that.val().split(',');
            dom = [];
            $.each(value,function (index,item) {
                dom.push($('.tag-item[data-name="' + name + '"] .btn[data-value="' + item + '"]'));
            })
            $.each(dom,function (index,item) {
                item.eq(0).removeClass('btn-outline btn-link tag').addClass('btn-primary btn-sm')
            })
        });
    })
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
    });
    $('.head_image').on('click',function (e) {
        var image = $(this).data('image');
        $eb.openImage(image);
    })
    var dateInput =$('.datepicker');
    dateInput.daterangepicker({
        autoUpdateInput: false,
        "opens": "center",
        "drops": "down",
        "ranges": {
             '今天': [moment(), moment().add(1, 'days')],
             '昨天': [moment().subtract(1, 'days'), moment()],
             '上周': [moment().subtract(6, 'days'), moment()],
             '前30天': [moment().subtract(29, 'days'), moment()],
             '本月': [moment().startOf('month'), moment().endOf('month')],
             '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale" : {
            applyLabel : '确定',
            cancelLabel : '清空',
            fromLabel : '起始时间',
            toLabel : '结束时间',
            format : 'YYYY/MM/DD',
            customRangeLabel : '自定义',
            daysOfWeek : [ '日', '一', '二', '三', '四', '五', '六' ],
            monthNames : [ '一月', '二月', '三月', '四月', '五月', '六月',
                '七月', '八月', '九月', '十月', '十一月', '十二月' ],
            firstDay : 1
        }
    });
    dateInput.on('cancel.daterangepicker', function(ev, picker) {
        $("#data").val('');
    });
    dateInput.on('apply.daterangepicker', function(ev, picker) {
        $("input[name=data]").val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        $('input[name=export]').val(0);
        $('#form').submit();
    });
    //发优惠券
    $('.grant').on('click',function (e) {
        var chk_value =[];
        var batch = $('#batch').val();
        if(batch == 1){
            $.each($list.data,function (index,item) {
                chk_value.push(item.uid);
            })
        }else if(batch == 2){
            chk_value = $uidAll;
        }else{
            $('input[name="coupon[]"]:checked').each(function(){
                chk_value.push($(this).val());
                str += $(this).val();
            });
            if(chk_value.length < 1){
                $eb.message('请选择要发放优惠券的用户');
                return false;
            }
        }
        var str = chk_value.join(',');
//        var url = "http://"+window.location.host+"/admin/store.store_coupon/grant/id/"+str;
        var url = layList.U({c:'store.store_coupon',a:'grant',p:{id:str}});
        $eb.createModalFrame(this.innerText,url,{'w':800});
    })
    $('.news').on('click',function (e) {
        var chk_value =[];
        var batch = $('#batch').val();
        if(batch == 1){
            $.each($list.data,function (index,item) {
                chk_value.push(item.uid);
            })
        }else if(batch == 2){
            chk_value = $uidAll;
        }else{
            $('input[name="coupon[]"]:checked').each(function(){
                chk_value.push($(this).val());
                str += $(this).val();
            });
            if(chk_value.length < 1){
                $eb.message('请选择要发消息的用户');
                return false;
            }
        }
        var str = chk_value.join(',');
//        var url = "http://"+window.location.host+"/admin/wechat.wechat_news_category/send_news/id/"+str;
        var url = layList.U({c:'wechat.wechat_news_category',a:'send_news',p:{id:str}});
        $eb.createModalFrame(this.innerText,url,{'w':800});
    })
    $('.synchro').on('click',function(){
        window.t = $(this);
        var _this = $(this),url =_this.data('url');
        $eb.$swal('delete',function(){
            $eb.axios.get(url).then(function(res){
                console.log(res);
                if(res.status == 200 && res.data.code == 200) {
                    $eb.$swal('success',res.data.msg);
                }else
                    return Promise.reject(res.data.msg || '同步失败')
            }).catch(function(err){
                $eb.$swal('error',err);
            });
        },{'title':'您确定要同步该用户的标签吗？','text':'请谨慎操作！','confirm':'是的，我要同步'})
    });
</script>


</div>
</body>
</html>
