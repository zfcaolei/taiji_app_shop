<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:77:"/data/wwwroot/app/application/admin/view/record/record/ranking_saleslists.php";i:1557993194;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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

<div class="layui-fluid">
    <div class="layui-row layui-col-space15"  id="app">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">搜索条件</div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">商品名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">时间范围</label>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="text" name="start_time" placeholder="开始时间" id="start_time" class="layui-input">
                                </div>
                                <div class="layui-form-mid">-</div>
                                <div class="layui-input-inline" style="width: 200px;">
                                    <input type="text" name="end_time" placeholder="结束时间" id="end_time" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" lay-submit="search" lay-filter="search">
                                        <i class="layui-icon layui-icon-search"></i>搜索</button>
                                    <button class="layui-btn layui-btn-primary layui-btn-sm export"  lay-submit="export" lay-filter="export">
                                        <i class="fa fa-floppy-o" style="margin-right: 3px;"></i>导出</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">资金监控日志</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="userList" lay-filter="userList"></table>
                    <script type="text/html" id="number">
                        <p><span>{{d.sum_price}}</span></p>
                    </script>
                    <script type="text/html" id="bar">
                        <button type="button" class="layui-btn layui-btn-xs" lay-event="see"><i class="layui-icon layui-icon-list"></i>详情</button>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>
<script>
    layList.form.render();
    layList.date({elem:'#start_time',theme:'#393D49',type:'datetime'});
    layList.date({elem:'#end_time',theme:'#393D49',type:'datetime'});
    layList.tableList('userList',"<?php echo Url('getSaleslists'); ?>",function () {
        return [
            {field: 'id', title: '商品编号', sort: true,event:'id'},
            {field: 'image', title: '商品图片',templet:'<p><img class="avatar " style="cursor: pointer" data-image="{{d.image}}" src="{{d.image}}" alt="{{d.store_name}}"></p>' },
            {field: 'store_name', title: '商品名称' },
            {field: 'price', title: '商品售价' },
            {field: 'number', title: '销售额',sort:true,templet:'#number'},
            {field: 'num_product', title: '销量'},
            {fixed: 'right', title: '操作',templet:'#bar'},
        ];
    });
    layList.search('search',function(where){
        if(where.start_time!=''){
            if(where.end_time==''){
                layList.msg('请选择结束时间');
                return;
            }
        }
        if(where.end_time!=''){
            if(where.start_time==''){
                layList.msg('请选择开始时间');
                return;
            }
        }
        layList.reload(where);
    });
    layList.search('export',function(where){
        location.href=layList.U({a:'save_product_export',q:{start_time:where.start_time,end_time:where.end_time,title:where.title}});
    });
    layList.tool(function (event,data){
        switch (event){
            case 'see':
                layList.createModalFrame(data.store_name+'-详情',layList.Url({a:'product_info',p:{id:data.id}}),{w:768});
                break;
        }
    });
</script>




</div>
</body>
</html>
