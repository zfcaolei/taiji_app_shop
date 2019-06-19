<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:92:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\store\store_product_reply\index.php";i:1556184114;s:77:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\container.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\inner_page.php";i:1556184114;s:80:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_footer.php";i:1556184114;}*/ ?>
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
    
<script src="/public/static/plug/sweetalert2/sweetalert2.all.min.js"></script>

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
                <div class="row">
                    <div class="m-b m-l">
                        <form action="" class="form-inline">
                            <select name="is_reply" aria-controls="editable" class="form-control input-sm">
                                <option value="">评论状态</option>
                                <option value="0" <?php if($where['is_reply'] == '0'): ?>selected="selected"<?php endif; ?>>未回复</option>
                                <option value="2" <?php if($where['is_reply'] == '2'): ?>selected="selected"<?php endif; ?>>已回复</option>
                            </select>
                            <div class="input-group">
                                <input type="text" name="comment" value="<?php echo $where['comment']; ?>" placeholder="请输入评论内容" class="input-sm form-control" size="38"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox">
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <div class="col-sm-12">
                        <div class="social-feed-box">
                            <div class="pull-right social-action dropdown">
                                <button data-toggle="dropdown" class="dropdown-toggle btn-white" aria-expanded="false">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu m-t-xs">
                                    <?php if($vo['is_reply'] == 2): ?>
                                    <li><a href="#" class="reply_update"  data-url="<?php echo Url('set_reply'); ?>"  data-content="<?php echo $vo['merchant_reply_content']; ?>" data-id="<?php echo $vo['id']; ?>">编辑</a></li>
                                    <?php else: ?>
                                    <li><a href="#" class="reply"  data-url="<?php echo Url('set_reply'); ?>" data-id="<?php echo $vo['id']; ?>">回复</a></li>
                                    <?php endif; ?>
                                    <li><a href="#" class="delete" data-url="<?php echo Url('delete',array('id'=>$vo['id'])); ?>">删除</a></li>
                                </ul>
                            </div>
                                <div class="social-avatar">
                                    <a href="" class="pull-left">
                                        <img alt="image" src="<?php echo $vo['headimgurl']; ?>">
                                    </a>
                                    <div class="media-body">
                                        <a href="#">
                                            <?php echo $vo['nickname']; ?>
                                        </a>
                                        <small class="text-muted"><?php echo date('Y-m-d H:i:s',$vo['add_time']); ?> 来自产品: <?php echo $vo['store_name']; ?></small>
                                    </div>
                                </div>
                                <div class="social-body">
                                    <div class="well">
                                        <?php echo $vo['comment']; ?>
                                        <br/>
                                        <?php  if(!empty($vo['pics'])) $image = explode(",",$vo['pics'][0]); else $image = [];if($image): if(is_array($image) || $image instanceof \think\Collection || $image instanceof \think\Paginator): $i = 0; $__LIST__ = $image;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                            <img src="<?php echo $v; ?>"  class="open_image m-t-sm" data-image="<?php echo $v; ?>" style="width: 50px;height: 50px;cursor: pointer;">
                                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                    </div>

                                        <p class="text-right">
                                        <div class="btn-group">
                                            <?php if($vo['is_reply'] == 2): ?>
                                            <button class="btn btn-info btn-xs reply_update"  data-url="<?php echo Url('set_reply'); ?>"  data-content="<?php echo $vo['merchant_reply_content']; ?>" data-id="<?php echo $vo['id']; ?>"><i class="fa fa-paste"></i> 编辑</button>
                                            <?php else: ?>
                                            <button class="btn btn-primary btn-xs reply"  data-url="<?php echo Url('set_reply'); ?>" data-id="<?php echo $vo['id']; ?>"><i class="fa fa-comments"></i> 回复</button>
                                            <?php endif; ?>
                                            <button class="btn btn-warning btn-xs delete" data-url="<?php echo Url('delete',array('id'=>$vo['id'])); ?>"><i class="fa fa-times"></i> 删除</button>
                                        </div>
                                        </p>


                                </div>
                                <?php if($vo['merchant_reply_content']): ?>
                                <div class="social-footer">
                                    <div class="social-comment">
                                        <div class="media-body">回复时间：<small class="text-muted"><?php echo date('Y-m-d H:i:s',$vo['merchant_reply_time']); ?></small></div>
                                    </div>
                                        <div class="well m">
                                            <p><?php echo $vo['merchant_reply_content']; ?></p>
                                        </div>

                                </div>
                                <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
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
    $('.delete').on('click',function(){
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
        })
    });
    $(".open_image").on('click',function (e) {
        var image = $(this).data('image');
        $eb.openImage(image);
    })
    $('.reply').on('click',function(){
        window.t = $(this);
        var _this = $(this),url =_this.data('url'),rid =_this.data('id');
        $eb.$alert('textarea',{'title':'请输入回复内容','value':''},function(result){
            $eb.axios.post(url,{content:result,id:rid}).then(function(res){
                if(res.status == 200 && res.data.code == 200) {
                    $eb.swal(res.data.msg);
                }else
                    $eb.swal(res.data.msg);
            });
        })
    });
    $('.reply_update').on('click',function (e) {
        window.t = $(this);
        var _this = $(this),url =_this.data('url'),rid =_this.data('id'),content =_this.data('content');
        $eb.$alert('textarea',{'title':'请输入回复内容','value':content},function(result){
            $eb.axios.post(url,{content:result,id:rid}).then(function(res){
                if(res.status == 200 && res.data.code == 200) {
                    $eb.swal(res.data.msg);
                }else{
                    $eb.swal(res.data.msg);
                }
            });
        })
    });
</script>


</div>
</body>
</html>
