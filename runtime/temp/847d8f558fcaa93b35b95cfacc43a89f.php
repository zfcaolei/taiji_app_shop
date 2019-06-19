<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:75:"/data/wwwroot/app/application/admin/view/system/system_databackup/index.php";i:1557993198;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>数据库备份记录</h5>
            </div>
            <div class="ibox-content" style="display: block;">
                <div class="table-responsive">
                    <table class="layui-hide" id="fileList" lay-filter="fileList"></table>
                    <script type="text/html" id="fileListtool">
                        <button type="button" class="layui-btn layui-btn-xs" lay-event="import"><i class="layui-icon layui-icon-edit"></i>导入</button>
                        <button type="button" class="layui-btn layui-btn-xs" lay-event="delFile"><i class="layui-icon layui-icon-edit"></i>删除</button>
                        <button type="button" class="layui-btn layui-btn-xs" lay-event="downloadFile"><i class="layui-icon layui-icon-edit"></i>下载</button>

                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>数据库表列表</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <script type="text/html" id="toolbarDemo">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="backup">备份</button>
                            <button class="layui-btn layui-btn-sm" lay-event="optimize">优化表</button>
                            <button class="layui-btn layui-btn-sm" lay-event="repair">修复表</button>
                        </div>
                    </script>
                    <table class="layui-hide" id="tableListID" lay-filter="tableListID"></table>
                    <script type="text/html" id="barDemo">
                        <button type="button" class="layui-btn layui-btn-xs" lay-event="see"><i class="layui-icon layui-icon-edit"></i>详情</button>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>
<script>
    function ipmosrting(time,part = null,start = null) {
        var datas = {
            time:time,
            part:part,
            start:start
        };
        $.ajax({
            url: layList.Url({a: 'import'}),
            data: datas,
            type: 'post',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if(res.data){
                    if(res.code){
                        setTimeout(ipmosrting(time,res.data.part,res.data.start),2000);
                    }
                }else{
                    layList.msg(res.msg);
                    return false;
                }

            },
            error: function (err) {
                console.log(err)
            }
        });

    }
    layui.use(['table', 'layer'], function(){
        var layer = layui.layer;
        var fileList = layui.table;
        var tableList = layui.table;
        //加载sql备份列表
        var buckdata = fileList.render({
            elem: '#fileList'
            ,url:"<?php echo Url('fileList'); ?>"
            ,cols: [[
                {field: 'filename', title: '备份名称', sort: true,width:'25%'},
                {field: 'part', title: 'part',width:'10%'},
                {field: 'size', title: '大小',width:'10%'},
                {field: 'compress', title: 'compress',width:'10%'},
                {field: 'backtime', title: '时间',width:'20%'},
                {fixed: 'right', title: '操作', width: '25%', align: 'center', toolbar: '#fileListtool'}
            ]]
            ,page: false
        });

        //监听工具条
        fileList.on('tool(fileList)', function(obj){
            var data = obj.data;
            var layEvent = obj.event;
            switch (layEvent){
                case 'import':
                    layer.confirm('真的倒入该备份吗？', function(index){
                        ipmosrting(data.time,null,null);
                        layer.close(index);
                    });
                    break;
                case 'delFile':
                    layer.confirm('真的删除该备份吗？', function(index){
                        layList.basePost(layList.Url({a:'delFile'}),{feilname:data.time},function (res) {
                            layer.msg(res.msg);
                            buckdata.reload();
                        });
                        obj.del();
                        layer.close(index);
                    });
                    break;
                case 'downloadFile':
                    location.href = layList.Url({a:'downloadFile',p:{feilname:data.time}});
                    break;
            }

        });
        //加载table
        tableList.render({
            elem: '#tableListID'
            ,url:"<?php echo Url('tablelist'); ?>"
            ,toolbar: '#toolbarDemo'
            ,cols: [[
                {type:'checkbox'},
                {field: 'name', title: '表名称', sort: true,width:'20%'},
                {field: 'comment', title: '备注',width:'20%'},
                {field: 'engine', title: '类型', sort: true,width:'10%'},
                {field: 'data_length', title: '大小',width:'10%', sort: true,totalRow: true},
                {field: 'update_time', title: '更新时间',width:'20%', sort: true},
                {field: 'rows', title: '行数'},
                {fixed: 'right', title: '操作', width: '10%', align: 'center', toolbar: '#barDemo'}
            ]]
            ,page: false
        });
        //头工具栏事件
        tableList.on('toolbar(tableListID)', function(obj){
            var checkStatus = tableList.checkStatus(obj.config.id);
            var data = checkStatus.data;
            var tables = [];
            $.each(data, function (name, value) {
                if (value['name'] != undefined) tables.push(value['name']);
            });
            if(tables.length < 1 ){
                return false;
            }
            switch(obj.event){
                case 'backup':
                    layList.basePost(layList.Url({a:'backup'}),{tables:tables},function (res) {
                        layer.msg(res.msg,{icon:1,time:1000,end:function(){
                            buckdata.reload();
                        }});
                    });
                    break;
                case 'optimize':
                    layList.basePost(layList.Url({a:'optimize'}),{tables:tables},function (res) {
                        layer.msg(res.msg);
                    });
                    break;
                case 'repair':
                    layList.basePost(layList.Url({a:'repair'}),{tables:tables},function (res) {
                        layer.msg(res.msg);
                    });
                    break;
            };
        });

        //监听并执行操作
        tableList.on('tool(tableListID)', function(obj){
            var data = obj.data;
            if(obj.event === 'see'){
                $eb.createModalFrame('表名:['+data.name+'] '+data.comment,layList.Url({a:'seetable',p:{tablename:data.name}}),{w:1000,h:600});
            }
        });

    });

</script>




</div>
</body>
</html>
