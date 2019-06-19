<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:71:"/data/wwwroot/app/application/admin/view/finance/user_extract/index.php";i:1557993190;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/inner_page.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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

                <div class="row">

                    <div class="m-b m-l">
                        <form action="" class="form-inline">

                            <select name="status" aria-controls="editable" class="form-control input-sm">

                                <option value="">提现状态</option>

                                <option value="-1" <?php if($where['status'] == '-1'): ?>selected="selected"<?php endif; ?>>未通过</option>

                                <option value="0" <?php if($where['status'] == '0'): ?>selected="selected"<?php endif; ?>>未提现</option>

                                <option value="1" <?php if($where['status'] == '1'): ?>selected="selected"<?php endif; ?>>已通过</option>

                            </select>
                            <select name="extract_type"  class="form-control input-sm">
                                <option value="">提现方式</option>
                                <option value="alipay" <?php if($where['extract_type'] == 'alipay'): ?>selected="selected"<?php endif; ?>>支付宝</option>
                                <option value="bank" <?php if($where['extract_type'] == 'bank'): ?>selected="selected"<?php endif; ?>>银行卡</option>
                                <option value="weixin" <?php if($where['extract_type'] == 'weixin'): ?>selected="selected"<?php endif; ?>>微信</option>
                            </select>
                            <div class="input-group">


                                  <span class="input-group-btn">
                                        <input type="text" name="nireid" value="<?php echo $where['nireid']; ?>" placeholder="微信昵称/姓名/支付宝账号/银行卡号" class="input-sm form-control" size="38">
                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                                     </span>

                            </div>


                        </form>


                    </div>



                </div>

                <div class="table-responsive">

                    <table class="table table-striped  table-bordered">

                        <thead>

                        <tr>

                            <th class="text-center">编号</th>
                            <th class="text-center">用户信息</th>
                            <th class="text-center">提现金额</th>
                            <th class="text-center">提现方式</th>
                            <th class="text-center">添加时间</th>
                            <th class="text-center">备注</th>
                            <th class="text-center">审核状态</th>
                            <th class="text-center">操作</th>

                        </tr>

                        </thead>

                        <tbody class="">

                        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

                        <tr>

                            <td class="text-center">

                                <?php echo $vo['id']; ?>

                            </td>

                            <td class="text-center">

                               用户昵称: <?php echo $vo['nickname']; ?>/用户id:<?php echo $vo['uid']; ?>

                            </td>



                            <td class="text-center" style="color: #00aa00;">

                                <?php echo $vo['extract_price']; ?>

                            </td>

                            <td class="text-left">

                                <?php if($vo['extract_type'] == 'bank'): ?>
                                姓名:<?php echo $vo['real_name']; ?><br>
                                 银行卡号:<?php echo $vo['bank_code']; ?>
                                <br/>
                                 银行开户地址:<?php echo $vo['bank_address']; elseif($vo['extract_type'] == 'weixin'): ?>
                                昵称:<?php echo $vo['nickname']; ?><br>
                                微信号号:<?php echo $vo['wechat']; else: ?>
                                姓名:<?php echo $vo['real_name']; ?><br>
                                  支付宝号:<?php echo $vo['alipay_code']; endif; ?>
                            </td>
                            <td class="text-center">

                                <?php echo date('Y-m-d H:i:s',$vo['add_time']); ?>

                            </td>
                            <td class="text-center">
                                <?php echo $vo['mark']; ?>
                            </td>
                            <td class="text-center">

                                <?php if($vo['status'] == 1): ?>

                                提现通过<br/>


                                <?php elseif($vo['status'] == -1): ?>

                                提现未通过<br/>

                                未通过原因：<?php echo $vo['fail_msg']; ?>
                                <br>
                                未通过时间：<?php echo date('Y-m-d H:i:s',$vo['fail_time']); else: ?>

                                未提现<br/>

                                <button data-url="<?php echo url('fail',['id'=>$vo['id']]); ?>" class="j-fail btn btn-danger btn-xs" type="button"><i class="fa fa-close"></i> 无效</button>

                                <button data-url="<?php echo url('succ',['id'=>$vo['id']]); ?>" class="j-success btn btn-primary btn-xs" type="button"><i class="fa fa-check"></i> 通过</button>

                                <?php endif; ?>

                            </td>

                            <td class="text-center">

                                <button class="btn btn-info btn-xs" type="button"  onclick="$eb.createModalFrame('编辑','<?php echo Url('edit',array('id'=>$vo['id'])); ?>')"><i class="fa fa-paste"></i> 编辑</button>

<!--                                <button class="btn btn-warning btn-xs" data-url="<?php echo Url('delete',array('id'=>$vo['id'])); ?>" type="button"><i class="fa fa-warning"></i> 删除</button>-->

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
    (function(){
        $('.j-fail').on('click',function(){
            var url = $(this).data('url');
            $eb.$alert('textarea',{
                title:'请输入未通过愿意',
                value:'输入信息不完整或有误!',
            },function(value){
                $eb.axios.post(url,{message:value}).then(function(res){
                    if(res.data.code == 200) {
                        $eb.$swal('success', res.data.msg);
                        setTimeout(function () {
                            window.location.reload();
                        },1000);
                    }else
                        $eb.$swal('error',res.data.msg||'操作失败!');
                });
            });
        });
        $('.j-success').on('click',function(){
            var url = $(this).data('url');
            $eb.$swal('delete',function(){
                $eb.axios.post(url).then(function(res){
                    if(res.data.code == 200) {
                        setTimeout(function () {
                            window.location.reload();
                        },1000);
                        $eb.$swal('success', res.data.msg);
                    }else
                        $eb.$swal('error',res.data.msg||'操作失败!');
                });
            },{
                title:'确定审核通过?',
                text:'通过后无法撤销，请谨慎操作！',
                confirm:'审核通过'
            });
        });
        $('.btn-warning').on('click',function(){
            window.t = $(this);
            var _this = $(this),url =_this.data('url');
            $eb.$swal('delete',function(){
                $eb.axios.get(url).then(function(res){
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
    }());
</script>



</div>
</body>
</html>
