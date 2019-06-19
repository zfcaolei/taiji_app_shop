<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:67:"/data/wwwroot/app/application/admin/view/user/user_notice/index.php";i:1557993200;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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
                <div class="layui-card-header">通知列表</div>
                <div class="layui-card-body">
                    <div class="layui-btn-container">
                        <button class="layui-btn layui-btn-sm" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('create'); ?>')">添加通知</button>
                    </div>
                    <table class="layui-hide" id="List" lay-filter="List"></table>
                    <!--消息状态-->
                    <script type="text/html" id="type">
                        {{# if(d.type==1){ }}
                            <p>系统消息</p>
                        {{# }else if(d.type==2){ }}
                            <p>用户通知</p>
                        {{# } }}
                    </script>
                    <!--消息状态-->
                    <script type="text/html" id="is_send">
                        {{# if(d.is_send==1){ }}
                        状态：<span style="color:green;">已发送</span><br />
                        时间：{{d.send_time}}
                        {{# }else{ }}
                        状态：<span style="color:red;">未发送</span> <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event='send'>立即发送</a>
                        {{# } }}
                    </script>
                    <script type="text/html" id="act">
                        <button type="button" class="layui-btn layui-btn-xs" onclick="dropdown(this)">操作 <span class="caret"></span></button>
                        <ul class="layui-nav-child layui-anim layui-anim-upbit">
                            <li>
                                <a href="javascript:;"  onclick="window.location.href='<?php echo Url('user'); ?>?id={{d.id}}'"><i class="fa fa-user"></i> 用户信息</a>
                            </li>
                            {{# if(d.is_send==0){ }}
                            <li>
                                <a href="javascript:;"  onclick="$eb.createModalFrame('编辑','<?php echo Url('edit'); ?>?id={{d.id}}')"><i class="fa fa-paste"></i> 编辑</a>
                            </li>
                            {{# } }}
                            <li>
                                <a href="javascript:;" lay-event='warning'><i class="fa fa-warning"></i> 删除</a>
                            </li>
                        </ul>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>



<script>
    layList.tableList('List',"<?php echo Url('index'); ?>",function (){
        return [
            {field: 'id', title: '编号', sort: true,event:'id'},
            {field: 'user', title: '发送人'},
            {field: 'title', title: '通知标题'},
            {field: 'content', title: '通知内容'},
            {field: 'type', title: '消息类型',templet:'#type'},
            {field: 'is_send', title: '是否发送',templet:'#is_send'},
            {field: 'right', title: '操作',align:'center',toolbar:'#act',width:'10%'},
        ];
    });
    //下拉框
    $(document).click(function (e) {
        $('.layui-nav-child').hide();
    })
    function dropdown(that){
        var oEvent = arguments.callee.caller.arguments[0] || event;
        oEvent.stopPropagation();
        var offset = $(that).offset();
        var top=offset.top-$(window).scrollTop();
        var index = $(that).parents('tr').data('index');
        $('.layui-nav-child').each(function (key) {
            if (key != index) {
                $(this).hide();
            }
        })
        if($(document).height() < top+$(that).next('ul').height()){
            $(that).next('ul').css({
                'padding': 10,
                'top': - ($(that).parents('td').height() / 2 + $(that).height() + $(that).next('ul').height()/2),
                'min-width': 'inherit',
                'position': 'absolute'
            }).toggle();
        }else{
            $(that).next('ul').css({
                'padding': 10,
                'top':$(that).parents('td').height() / 2 + $(that).height(),
                'min-width': 'inherit',
                'position': 'absolute'
            }).toggle();
        }
    }
    layList.tool(function (event,data,obj) {
        switch (event) {
            case 'send':
                var url =layList.U({c:'user.user_notice',a:'send',p:{id:data.id}});
                $eb.$swal('delete',function(){
                    $eb.axios.get(url).then(function(res){
                        if(res.status == 200 && res.data.code == 200) {
                            $eb.$swal('success',res.data.msg);
                            obj.update({is_send:1,send_time:'<?php echo date("Y-m-d H:i:s",time()); ?>'});
                        }else
                            return Promise.reject(res.data.msg || '发送失败')
                    }).catch(function(err){
                        $eb.$swal('error',err);
                    });
                },{
                    title:"您确定要发送这条信息吗",
                    text:"发送后将无法修改通知信息，请谨慎操作！",
                    confirm:"是的，我要发送！",
                    cancel:"让我再考虑一下"
                })
                break;
            case 'warning':
                window.t = $(this);
                var _this = obj,url =layList.U({a:'delete',p:{id:data.id}});
                $eb.$swal('delete',function(){
                    $eb.axios.get(url).then(function(res){
                        if(res.status == 200 && res.data.code == 200) {
                            $eb.$swal('success',res.data.msg);
                            _this.del();
                        }else
                            return Promise.reject(res.data.msg || '删除失败')
                    }).catch(function(err){
                        $eb.$swal('error',err);
                    });
                })
                break;
        }
    })
    $('.head_image').on('click',function (e) {
        var image = $(this).data('image');
        $eb.openImage(image);
    })
</script>


</div>
</body>
</html>
