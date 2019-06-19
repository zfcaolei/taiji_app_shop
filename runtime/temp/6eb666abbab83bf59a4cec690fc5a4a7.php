<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:73:"/data/wwwroot/app/application/admin/view/order/store_order/order_info.php";i:1557993191;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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

<div class="ibox-content order-info">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    收货信息
                </div>
                <div class="panel-body">
                    <div class="row show-grid">
                        <div class="col-xs-12" >用户昵称: <?php echo $userInfo['nickname']; ?></div>
                        <div class="col-xs-12">收货人: <?php echo $orderInfo['real_name']; ?></div>
                        <div class="col-xs-12">联系电话: <?php echo $orderInfo['user_phone']; ?></div>
                        <div class="col-xs-12">收货地址: <?php echo $orderInfo['user_address']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    订单信息
                </div>
                <div class="panel-body">
                    <div class="row show-grid">
                        <div class="col-xs-6" >订单编号: <?php echo $orderInfo['order_id']; ?></div>
                        <div class="col-xs-6" style="color: #8BC34A;">订单状态:
                            <?php if($orderInfo['paid'] == 0 && $orderInfo['status'] == 0): ?>
                            未支付
                            <?php elseif($orderInfo['paid'] == 1 && $orderInfo['status'] == 0 && $orderInfo['refund_status'] == 0): ?>
                            未发货
                            <?php elseif($orderInfo['paid'] == 1 && $orderInfo['status'] == 1 && $orderInfo['refund_status'] == 0): ?>
                            待收货
                            <?php elseif($orderInfo['paid'] == 1 && $orderInfo['status'] == 2 && $orderInfo['refund_status'] == 0): ?>
                            待评价
                            <?php elseif($orderInfo['paid'] == 1 && $orderInfo['status'] == 3 && $orderInfo['refund_status'] == 0): ?>
                            交易完成
                            <?php elseif($orderInfo['paid'] == 1 && $orderInfo['refund_status'] == 1): ?>
                            申请退款<b style="color:#f124c7"><?php echo $orderInfo['refund_reason_wap']; ?></b>
                            <?php elseif($orderInfo['paid'] == 1 && $orderInfo['refund_status'] == 2): ?>
                            已退款
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-6">商品总数: <?php echo $orderInfo['total_num']; ?></div>
                        <div class="col-xs-6">商品总价: ￥<?php echo $orderInfo['total_price']; ?></div>
                        <div class="col-xs-6">支付邮费: ￥<?php echo $orderInfo['total_postage']; ?></div>
                        <div class="col-xs-6">优惠券金额: ￥<?php echo $orderInfo['coupon_price']; ?></div>
                        <div class="col-xs-6">实际支付: ￥<?php echo $orderInfo['pay_price']; ?></div>
                        <?php if($orderInfo['refund_price'] > 0): ?>
                        <div class="col-xs-6" style="color: #f1a417">退款金额: ￥<?php echo $orderInfo['refund_price']; ?></div>
                        <?php endif; if($orderInfo['use_integral'] > 0): ?>
                        <div class="col-xs-6" style="color: #f1a417">使用积分: <?php echo $orderInfo['use_integral']; ?>积分(抵扣了￥<?php echo $orderInfo['deduction_price']; ?>)</div>
                        <?php endif; if($orderInfo['back_integral'] > 0): ?>
                        <div class="col-xs-6" style="color: #f1a417">退回积分: ￥<?php echo $orderInfo['back_integral']; ?></div>
                        <?php endif; ?>
                        <div class="col-xs-6">创建时间: <?php echo date("Y/m/d H:i",$orderInfo['add_time']); ?></div>
                        <div class="col-xs-6">支付方式:
                            <?php if($orderInfo['paid'] == 1): if($orderInfo['pay_type'] == 'weixin'): ?>
                               微信支付
                               <?php elseif($orderInfo['pay_type'] == 'yue'): ?>
                               余额支付
                               <?php elseif($orderInfo['pay_type'] == 'offline'): ?>
                               线下支付
                               <?php else: ?>
                               其他支付
                               <?php endif; else: if($orderInfo['pay_type'] == 'offline'): ?>
                            线下支付
                            <?php else: ?>
                            未支付
                            <?php endif; endif; ?>
                        </div>
                        <?php if(!(empty($orderInfo['pay_time']) || (($orderInfo['pay_time'] instanceof \think\Collection || $orderInfo['pay_time'] instanceof \think\Paginator ) && $orderInfo['pay_time']->isEmpty()))): ?>
                        <div class="col-xs-6">支付时间: <?php echo date("Y/m/d H:i",$orderInfo['pay_time']); ?></div>
                        <?php endif; ?>
                        <div class="col-xs-6" style="color: #ff0005">用户备注: <?php echo !empty($orderInfo['mark'])?$orderInfo['mark']:'无'; ?></div>
                        <div class="col-xs-6" style="color: #733AF9">推广人: <?php if($spread): ?><?php echo $spread; else: ?>无<?php endif; ?></div>
                        <div class="col-xs-6" style="color: #733b5c">商家备注: <?php echo !empty($orderInfo['remark'])?$orderInfo['remark']:'无'; ?></div>

                    </div>
                </div>
            </div>
        </div>
        <?php if($orderInfo['delivery_type'] == 'express'): ?>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    物流信息
                </div>
                <div class="panel-body">
                    <div class="row show-grid">
                        <div class="col-xs-6" >快递公司: <?php echo $orderInfo['delivery_name']; ?></div>
                        <div class="col-xs-6">快递单号: <?php echo $orderInfo['delivery_id']; ?> | <button class="btn btn-info btn-xs" type="button"  onclick="$eb.createModalFrame('物流查询','<?php echo Url('express',array('oid'=>$orderInfo['id'])); ?>',{w:322,h:568})">物流查询</button></div>
                    </div>
                </div>
            </div>
        </div>
        <?php elseif($orderInfo['delivery_type'] == 'send'): ?>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    配送信息
                </div>
                <div class="panel-body">
                    <div class="row show-grid">
                        <div class="col-xs-6" >送货人姓名: <?php echo $orderInfo['delivery_name']; ?></div>
                        <div class="col-xs-6">送货人电话: <?php echo $orderInfo['delivery_id']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    备注信息
                </div>
                <div class="panel-body">
                    <div class="row show-grid">
                        <div class="col-xs-6" ><?php if($orderInfo['mark']): ?><?php echo $orderInfo['mark']; else: ?>暂无备注信息<?php endif; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/public/system/frame/js/content.min.js?v=1.0.0"></script>






</div>
</body>
</html>
