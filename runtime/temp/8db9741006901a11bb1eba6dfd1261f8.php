<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:87:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\store\store_category\index.php";i:1556184114;s:77:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\container.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;s:80:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_footer.php";i:1556184114;}*/ ?>
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
                                <label class="layui-form-label">所有分类</label>
                                <div class="layui-input-block">
                                    <select name="is_show">
                                        <option value="">是否显示</option>
                                        <option value="1">显示</option>
                                        <option value="0">不显示</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">所有分类</label>
                                <div class="layui-input-block">
                                    <select name="pid">
                                        <option value="">所有菜单</option>
                                        <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['html']; ?><?php echo $vo['cate_name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">产品名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="cate_name" class="layui-input" placeholder="请输入分类名称">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" lay-submit="search" lay-filter="search">
                                        <i class="layui-icon layui-icon-search"></i>搜索</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--产品列表-->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">分类列表</div>
                <div class="layui-card-body">
                    <div class="alert alert-info" role="alert">
                        注:点击父级名称可查看子集分类,点击分页首页可返回顶级分类;分类名称和排序可进行快速编辑;
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="layui-btn-container">
                        <a class="layui-btn layui-btn-sm" href="<?php echo Url('index'); ?>">分类首页</a>
                        <button type="button" class="layui-btn layui-btn-sm" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('create'); ?>')">添加分类</button>
                    </div>
                    <table class="layui-hide" id="List" lay-filter="List"></table>
                    <script type="text/html" id="pic">
                        <img style="cursor: pointer" lay-event='open_image' src="{{d.pic}}">
                    </script>
                    <script type="text/html" id="is_show">
                        <input type='checkbox' name='id' lay-skin='switch' value="{{d.id}}" lay-filter='is_show' lay-text='显|隐'  {{ d.is_show == 1 ? 'checked' : '' }}>
                    </script>
                    <script type="text/html" id="pid">
                        <a href="<?php echo Url('index'); ?>?pid={{d.id}}">查看</a>
                    </script>
                    <script type="text/html" id="act">
                        <button class="layui-btn layui-btn-xs" onclick="$eb.createModalFrame('编辑','<?php echo Url('edit'); ?>?id={{d.id}}')">
                            <i class="fa fa-paste"></i> 编辑
                        </button>
                        <button class="layui-btn layui-btn-xs" lay-event='delstor'>
                            <i class="fa fa-warning"></i> 删除
                        </button>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>



<script>
    setTimeout(function () {
        $('.alert-info').hide();
    },3000);
    //实例化form
    layList.form.render();
    //加载列表
    layList.tableList('List',"<?php echo Url('category_list',['pid'=>$pid]); ?>",function (){
        return [
            {field: 'id', title: 'ID', sort: true,event:'id',width:'6%'},
            {field: 'pid_name', title: '父级'},
            {field: 'cate_name', title: '分类名称',edit:'cate_name'},
            {field: 'pid', title: '查看子分类',templet:'#pid'},
            {field: 'pic', title: '分类图标',templet:'#pic'},
            {field: 'sort', title: '排序',sort: true,event:'sort',edit:'sort',width:'8%'},
            {field: 'is_show', title: '状态',templet:'#is_show',width:'6%'},
            {field: 'right', title: '操作',align:'center',toolbar:'#act',width:'14%'},
        ];
    });
    //自定义方法
    var action= {
        set_category: function (field, id, value) {
            layList.baseGet(layList.Url({
                c: 'store.store_category',
                a: 'set_category',
                q: {field: field, id: id, value: value}
            }), function (res) {
                layList.msg(res.msg);
            });
        },
    }
    //查询
    layList.search('search',function(where){
        layList.reload(where);
    });
    layList.switch('is_show',function (odj,value) {
        if(odj.elem.checked==true){
            layList.baseGet(layList.Url({c:'store.store_category',a:'set_show',p:{is_show:1,id:value}}),function (res) {
                layList.msg(res.msg);
            });
        }else{
            layList.baseGet(layList.Url({c:'store.store_category',a:'set_show',p:{is_show:0,id:value}}),function (res) {
                layList.msg(res.msg);
            });
        }
    });
    //快速编辑
    layList.edit(function (obj) {
        var id=obj.data.id,value=obj.value;
        switch (obj.field) {
            case 'cate_name':
                action.set_category('cate_name',id,value);
                break;
            case 'sort':
                action.set_category('sort',id,value);
                break;
        }
    });
    //监听并执行排序
    layList.sort(['id','sort'],true);
    //点击事件绑定
    layList.tool(function (event,data,obj) {
        switch (event) {
            case 'delstor':
                var url=layList.U({c:'store.store_category',a:'delete',q:{id:data.id}});
                $eb.$swal('delete',function(){
                    $eb.axios.get(url).then(function(res){
                        if(res.status == 200 && res.data.code == 200) {
                            $eb.$swal('success',res.data.msg);
                            obj.del();
                        }else
                            return Promise.reject(res.data.msg || '删除失败')
                    }).catch(function(err){
                        $eb.$swal('error',err);
                    });
                })
                break;
            case 'open_image':
                $eb.openImage(data.pic);
                break;
        }
    })
</script>


</div>
</body>
</html>
