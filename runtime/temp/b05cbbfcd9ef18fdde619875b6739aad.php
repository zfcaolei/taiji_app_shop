<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:79:"/data/wwwroot/app/application/admin/view/wechat/wechat_news_category/select.php";i:1557993202;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/inner_page.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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
<link href="/public/system/module/wechat/news_category/css/style.css" type="text/css" rel="stylesheet"><div class="row">    <div class="col-sm-12">        <div class="ibox">            <div class="ibox-title">                <div class="row">                    <div class="col-sm-8 m-b-xs">                        <form action="" class="form-inline">                            <i class="fa fa-search" style="margin-right: 10px;"></i>                            <div class="input-group">                                <input type="text" name="cate_name" value="<?php echo $where['cate_name']; ?>" placeholder="请输入关键词" class="input-sm form-control"> <span class="input-group-btn">                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>                            </div>                        </form>                    </div>                </div>            </div>            <div class="ibox-content">                <?php                $new_list = array();                $new_list = $list->toArray();                $new_list = $new_list['data'];                foreach ($new_list as $k=>$v){                    $new_list[$k]['new'] = $v['new']->toArray();                }                ?>                <div id="news_box">                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>                    <div class="news_item category_one" style="float: left;cursor: pointer" data-id="<?php echo $vo['id']; ?>">                        <div class="title"><span>图文名称：<?php echo $vo['cate_name']; ?></span></div>                    <?php if(is_array($vo['new']) || $vo['new'] instanceof \think\Collection || $vo['new'] instanceof \think\Paginator): $k = 0; $__LIST__ = $vo['new'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvo): $mod = ($k % 2 );++$k;if($k == 1): ?>                        <div class="news_articel_item" style="background-image:url(<?php echo $vvo['image_input']; ?>)">                            <p><?php echo $vvo['title']; ?></p>                        </div>                        <div class="hr-line-dashed"></div>                        <?php else: ?>                        <div class="news_articel_item other">                            <div class="right-text"><?php echo $vvo['title']; ?></div>                            <div class="left-image" style="background-image:url(<?php echo $vvo['image_input']; ?>);">                            </div>                        </div>                        <div class="hr-line-dashed"></div>                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>                    </div>                <?php endforeach; endif; else: echo "" ;endif; ?>                </div>            </div>        </div>    </div></div><div style="margin-left: 10px">    <link href="/public/system/frame/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" id="DataTables_Table_0_info" role="alert" aria-live="polite" aria-relevant="all">共 <?php echo $total; ?> 项</div>
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
            <?php echo $page; ?>
        </div>
    </div>
</div></div><?php $new_json = json_encode($new_list)?>

<script>    $('.category_one').on('click',function (e) {        var callback = "<?php echo $callback; ?>";        var id = $(this).data('id');        var _new = <?php echo $new_json; ?>;        console.log(id);        $.each(_new,function (key,value) {            if(value['id'] == id){                console.log(_new[key]);                parent[callback](_new[key])            }        })    })</script>

</div>
</body>
</html>
