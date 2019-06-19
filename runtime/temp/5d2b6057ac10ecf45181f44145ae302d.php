<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:91:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\order\store_order\order_status.php";i:1556184114;s:77:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\container.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\inner_page.php";i:1556184114;s:80:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_footer.php";i:1556184114;}*/ ?>
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

<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped  table-bordered">
                        <thead>
                        <tr>

                            <th class="text-center">订单编号</th>
                            <th class="text-center">操作记录</th>
                            <th class="text-center">操作时间</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td class="text-center">
                                <?php echo $vo['oid']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $vo['change_message']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo date('Y-m-d H:i:s',$vo['change_time']); ?>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
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
    $('.btn-warning').on('click',function(){
        window.t = $(this);
        var _this = $(this),url =_this.data('url');
        $eb.$swal('delete',function(){
            $eb.axios.get(url).then(function(res){
                console.log(res);
                if(res.status == 200 && res.data.code == 200) {
                    $eb.$swal('success',res.data.msg);
//                        _this.parents('tr').remove();
                }else
                    return Promise.reject(res.data.msg || '修改失败')
            }).catch(function(err){
                $eb.$swal('error',err);
            });
        },{'title':'您确定要修改优惠券的状态吗？','text':'修改后将无法恢复并且已发出的优惠券将失效,请谨慎操作！','confirm':'是的，我要修改'})
    });
    $('.btn-danger').on('click',function(){
        window.t = $(this);
        var _this = $(this),url =_this.data('url');
        $eb.$swal('delete',function(){
            $eb.axios.get(url).then(function(res){
                console.log(res);
                if(res.status == 200 && res.data.code == 200) {
                    $eb.$swal('success',res.data.msg);
                        _this.parents('tr').remove();
                }else
                    return Promise.reject(res.data.msg || '删除失败')
            }).catch(function(err){
                $eb.$swal('error',err);
            });
        },{'title':'您确定要删除优惠券吗？','text':'删除后将无法恢复,请谨慎操作！','confirm':'是的，我要删除'})
    });
    $(".open_image").on('click',function (e) {
        var image = $(this).data('image');
        $eb.openImage(image);
    })
</script>


</div>
</body>
</html>
