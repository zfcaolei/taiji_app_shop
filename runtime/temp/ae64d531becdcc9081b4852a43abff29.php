<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:70:"/data/wwwroot/app/application/admin/view/store/store_product/index.php";i:1560655894;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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

<div class="layui-fluid" style="background: #fff;margin-top: -10px;">
    <div class="layui-tab layui-tab-brief" lay-filter="tab">
        <ul class="layui-tab-title">
            <li lay-id="list" <?php if($type == '1'): ?>class="layui-this" <?php endif; ?> >
                <a href="<?php if($type == '1'): ?>javascript:;<?php else: ?><?php echo Url('index',['type'=>1]); endif; ?>">出售中产品(<?php echo $onsale; ?>)</a>
            </li>
            <li lay-id="list" <?php if($type == '2'): ?>class="layui-this" <?php endif; ?>>
                <a href="<?php if($type == '2'): ?>javascript:;<?php else: ?><?php echo Url('index',['type'=>2]); endif; ?>">待上架产品(<?php echo $forsale; ?>)</a>
            </li>
            <li lay-id="list" <?php if($type == '3'): ?>class="layui-this" <?php endif; ?>>
                <a href="<?php if($type == '3'): ?>javascript:;<?php else: ?><?php echo Url('index',['type'=>3]); endif; ?>">仓库中产品(<?php echo $warehouse; ?>)</a>
            </li>
            <li lay-id="list" <?php if($type == '4'): ?>class="layui-this" <?php endif; ?>>
                <a href="<?php if($type == '4'): ?>javascript:;<?php else: ?><?php echo Url('index',['type'=>4]); endif; ?>">已经售馨产品(<?php echo $outofstock; ?>)</a>
            </li>
            <li lay-id="list" <?php if($type == '5'): ?>class="layui-this" <?php endif; ?>>
                <a href="<?php if($type == '5'): ?>javascript:;<?php else: ?><?php echo Url('index',['type'=>5]); endif; ?>">警戒库存(<?php echo $policeforce; ?>)</a>
            </li>
            <li lay-id="list" <?php if($type == '6'): ?>class="layui-this" <?php endif; ?>>
                <a href="<?php if($type == '6'): ?>javascript:;<?php else: ?><?php echo Url('index',['type'=>6]); endif; ?>">产品回收站(<?php echo $recycle; ?>)</a>
            </li>
        </ul>
    </div>
    <div class="layui-row layui-col-space15"  id="app">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">所有分类</label>
                                <div class="layui-input-block">
                                    <select name="cate_id">
                                        <option value=" ">全部</option>
                                        <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['html']; ?><?php echo $vo['cate_name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">产品名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="store_name" class="layui-input" placeholder="请输入产品名称,关键字,编号">
                                    <input type="hidden" name="type" value="<?php echo $type; ?>">
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
        <!--产品列表-->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body">
                    <div class="alert alert-info" role="alert">
                        列表[产品价格],[虚拟销量],[库存]可进行快速修改,双击或者单击进入编辑模式,失去焦点可进行自动保存
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="layui-btn-container">
                        <?php switch($type): case "1": ?>
                                <button class="layui-btn layui-btn-sm" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('create'); ?>',{h:700,w:1100})">添加产品</button>
                            <?php break; case "2": ?>
                                <button class="layui-btn layui-btn-sm" data-type="show">批量上架</button>
                            <?php break; endswitch; ?>
                    </div>
                    <table class="layui-hide" id="List" lay-filter="List"></table>
                    <!--图片-->
                    <script type="text/html" id="image">
                        <img style="cursor: pointer" lay-event="open_image" src="{{d.image}}">
                    </script>
                    <!--上架|下架-->
                    <script type="text/html" id="checkboxstatus">
                        <input type='checkbox' name='id' lay-skin='switch' value="{{d.id}}" lay-filter='is_show' lay-text='上架|下架'  {{ d.is_show == 1 ? 'checked' : '' }}>
                    </script>
                    <!--收藏-->
                    <script type="text/html" id="like">
                        <span><i class="layui-icon layui-icon-praise"></i> {{d.like}}</span>
                    </script>
                    <!--点赞-->
                    <script type="text/html" id="collect">
                        <span><i class="layui-icon layui-icon-star"></i> {{d.collect}}</span>
                    </script>
                    <!--产品名称-->
                    <script type="text/html" id="store_name">
                        <h4>{{d.store_name}}</h4>
                        <p>价格:<font color="red">{{d.price}}</font> </p>
                        {{# if(d.cate_name!=''){ }}
                        <p>分类:{{d.cate_name}}</p>
                        {{# } }}
                        <p>访客量:{{d.visitor}}</p>
                        <p>浏览量:{{d.browse}}</p>
                    </script>
                    <!--操作-->
                    <script type="text/html" id="act">
                        <button type="button" class="layui-btn layui-btn-xs btn-success" onclick="$eb.createModalFrame('{{d.store_name}}-属性','<?php echo Url('attr'); ?>?id={{d.id}}',{h:600,w:800})">
                            属性
                        </button>
                        <button type="button" class="layui-btn layui-btn-xs layui-btn-normal" onclick="$eb.createModalFrame('{{d.store_name}}-编辑','<?php echo Url('edit'); ?>?id={{d.id}}',{h:700,w:1100})">
                            编辑
                        </button>
                        <a type="button" class="layui-btn layui-btn-xs layui-btn-normal" href="<?php echo Url('create3d'); ?>?id={{d.id}}">
                            3d
                        </a>
                        <a type="button" class="layui-btn layui-btn-xs layui-btn-normal" href="<?php echo Url('createvedio'); ?>?id={{d.id}}">
                            视频
                        </a>
                        <button type="button" class="layui-btn layui-btn-xs" onclick="dropdown(this)">操作 <span class="caret"></span></button>
                        <ul class="layui-nav-child layui-anim layui-anim-upbit">
                            <li>
                                <a href="javascript:void(0);" class="" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('edit_content'); ?>?id={{d.id}}')">
                                    <i class="fa fa-pencil"></i> 产品详情</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('ump.store_seckill/seckill'); ?>?id={{d.id}}')"">
                                <i class="fa fa-gavel"></i> 开启秒杀</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('ump.store_bargain/bargain'); ?>?id={{d.id}}')">
                                    <i class="fa fa-sort-amount-asc"></i> 开启砍价</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="$eb.createModalFrame(this.innerText,'<?php echo Url('ump.store_combination/combination'); ?>?id={{d.id}}')">
                                    <i class="fa fa-hand-lizard-o"></i> 开启拼团</a>
                            </li>
                            {{# if(d.is_del){ }}
                            <li>
                                <a href="javascript:void(0);" lay-event='delstor'>
                                    <i class="fa fa-trash"></i> 恢复产品
                                </a>
                            </li>
                            {{# }else{ }}
                            <li>
                                <a href="javascript:void(0);" lay-event='delstor'>
                                    <i class="fa fa-trash"></i> 移到回收站
                                </a>
                            </li>
                            {{# } }}
                            <li>
                                <a href="<?php echo Url('store.storeProductReply/index'); ?>?product_id={{d.id}}">
                                    <i class="fa fa-warning"></i> 评论查看
                                </a>
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
    var type=<?=$type?>;
    //实例化form
    layList.form.render();
    //加载列表
    layList.tableList('List',"<?php echo Url('product_ist',['type'=>$type]); ?>",function (){
        var join=new Array();
        switch (parseInt(type)){
            case 1:case 3:case 4:case 5:
                join=[
                    {field: 'id', title: 'ID', sort: true,event:'id',width:'6%'},
                    {field: 'image', title: '产品图片',templet:'#image',width:'10%'},
                    {field: 'store_name', title: '产品名称',templet:'#store_name'},
                    {field: 'ficti', title: '虚拟销量',edit:'ficti',width:'8%'},
                    {field: 'stock', title: '库存',edit:'stock',width:'8%'},
                    {field: 'sort', title: '排序',edit:'sort',width:'6%'},
                    {field: 'sales', title: '销量',sort: true,event:'sales',width:'8%'},
                    {field: 'collect', title: '点赞',templet:'#like',width:'6%'},
                    {field: 'like', title: '收藏',templet:'#collect',width:'6%'},
                    {field: 'status', title: '状态',templet:"#checkboxstatus",width:'8%'},
                    {field: 'right', title: '操作',align:'center',toolbar:'#act',width:'14%'},
                ];
                break;
            case 2:
                join=[
                    {type:'checkbox'},
                    {field: 'id', title: 'ID', sort: true,event:'id',width:'6%'},
                    {field: 'image', title: '产品图片',templet:'#image',width:'10%'},
                    {field: 'store_name', title: '产品名称',templet:'#store_name'},
                    {field: 'price', title: '价格',edit:'price',width:'8%'},
                    {field: 'ficti', title: '虚拟销量',edit:'ficti',width:'8%'},
                    {field: 'stock', title: '库存',edit:'stock',width:'6%'},
                    {field: 'sort', title: '排序',edit:'sort',width:'6%'},
                    {field: 'sales', title: '销量',sort: true,event:'sales',width:'6%'},
                    {field: 'status', title: '状态',templet:"#checkboxstatus",width:'8%'},
                    {field: 'right', title: '操作',align:'center',toolbar:'#act',width:'14%'},
                ];
                break;
            case 6:
                join=[
                    {field: 'id', title: '产品ID', sort: true,event:'id'},
                    {field: 'image', title: '产品图片',templet:'#image'},
                    {field: 'store_name', title: '产品名称',templet:'#store_name'},
                    {field: 'price', title: '产品价格',edit:'price'},
                    {field: 'ficti', title: '虚拟销量',edit:'ficti'},
                    {field: 'stock', title: '库存',edit:'stock'},
                    {field: 'sort', title: '排序',edit:'sort'},
                    {field: 'sales', title: '销量',sort: true,event:'sales'},
//                    {field: 'status', title: '状态',templet:"#checkboxstatus"},
                    {field: 'right', title: '操作',align:'center',toolbar:'#act',width:'14%'},
                ];
                break;
        }
        return join;
    })
    //excel下载
    layList.search('export',function(where){
        location.href=layList.U({c:'store.store_product',a:'product_ist',q:{
                cate_id:where.cate_id,
                store_name:where.store_name,
                type:where.type,
                excel:1
            }});
    })
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
                'top': - ($(that).parent('td').height() / 2 + $(that).height() + $(that).next('ul').height()/2),
                'min-width': 'inherit',
                'position': 'absolute'
            }).toggle();
        }else{
            $(that).next('ul').css({
                'padding': 10,
                'top':$(that).parent('td').height() / 2 + $(that).height(),
                'min-width': 'inherit',
                'position': 'absolute'
            }).toggle();
        }
    }
    //快速编辑
    layList.edit(function (obj) {
        var id=obj.data.id,value=obj.value;
        switch (obj.field) {
            case 'price':
                action.set_product('price',id,value);
                break;
            case 'stock':
                action.set_product('stock',id,value);
                break;
            case 'sort':
                action.set_product('sort',id,value);
                break;
            case 'ficti':
                action.set_product('ficti',id,value);
                break;
        }
    });
    //上下加产品
    layList.switch('is_show',function (odj,value) {
        if(odj.elem.checked==true){
            layList.baseGet(layList.Url({c:'store.store_product',a:'set_show',p:{is_show:1,id:value}}),function (res) {
                layList.msg(res.msg);
            });
        }else{
            layList.baseGet(layList.Url({c:'store.store_product',a:'set_show',p:{is_show:0,id:value}}),function (res) {
                layList.msg(res.msg);
            });
        }
    });
    //点击事件绑定
    layList.tool(function (event,data,obj) {
        switch (event) {
            case 'delstor':
                var url=layList.U({c:'store.store_product',a:'delete',q:{id:data.id}});
                if(data.is_del) var code = {title:"操作提示",text:"确定恢复产品操作吗？",type:'info',confirm:'是的，恢复该产品'};
                else var code = {title:"操作提示",text:"确定将该产品移入回收站吗？",type:'info',confirm:'是的，移入回收站'};
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
                },code)
                break;
            case 'open_image':
                $eb.openImage(data.image);
                break;
        }
    })
    //排序
    layList.sort(function (obj) {
        var type = obj.type;
        switch (obj.field){
            case 'id':
                layList.reload({order: layList.order(type,'p.id')},true,null,obj);
                break;
            case 'sales':
                layList.reload({order: layList.order(type,'p.sales')},true,null,obj);
                break;
        }
    });
    //查询
    layList.search('search',function(where){
        layList.reload(where);
    });
    //自定义方法
    var action={
        set_product:function(field,id,value){
            layList.baseGet(layList.Url({c:'store.store_product',a:'set_product',q:{field:field,id:id,value:value}}),function (res) {
                layList.msg(res.msg);
            });
        },
        show:function(){
            var ids=layList.getCheckData().getIds('id');
            if(ids.length){
                layList.basePost(layList.Url({c:'store.store_product',a:'product_show'}),{ids:ids},function (res) {
                    layList.msg(res.msg);
                    layList.reload();
                });
            }else{
                layList.msg('请选择要上架的产品');
            }
        }
    };
    //多选事件绑定
    $('.layui-btn-container').find('button').each(function () {
        var type=$(this).data('type');
        $(this).on('click',function(){
            action[type] && action[type]();
        })
    });
</script>




</div>
</body>
</html>
