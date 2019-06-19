<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:92:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\setting\system_admin\admin_info.php";i:1556184114;s:77:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\container.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;s:80:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_footer.php";i:1556184114;}*/ ?>
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
    
<style>
    label.error{
        color: #a94442;
        margin-bottom: 0;
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        transform: translate(0, 0);
    }
</style>
<link href="/public/system/frame/css/plugins/iCheck/custom.css" rel="stylesheet">
<script src="/public/system/plug/validate/jquery.validate.js"></script>
<script src="/public/system/frame/js/plugins/iCheck/icheck.min.js"></script>
<script src="/public/system/frame/js/ajaxfileupload.js"></script>

</head>
<body class="gray-bg">
<!--演示地址https://daneden.github.io/animate.css/?-->
<div class="wrapper wrapper-content animated ">

<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div class="ibox-title">
                <div class="text-left">个人资料</div>
                <div class="ibox-tools">

                </div>
            </div>
            <div class="ibox-content">
                <form method="post" class="form-horizontal" id="signupForm" action="">
                    <input type="hidden" value="<?php echo $adminInfo['id']; ?>" name="id"/>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">账号</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="account" value="<?php echo $adminInfo['account']; ?>" validate="" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="real_name" value="<?php echo $adminInfo['real_name']; ?>" validate="required:true" id="real_name"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">原始密码</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="pwd"  id="pwd"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="new_pwd" id="new_pwd"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">确认新密码</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="new_pwd_ok" id="new_pwd_ok"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary add" type="button">提交</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>




<script>
    $eb = parent._mpApi;
    $().ready(function() {
        $("#signupForm").validate();
    })
    $('.add').on('click',function (e) {
         var list = [];
         list.real_name = $('#real_name').val();
         list.pwd = $('#pwd').val();
         list.new_pwd = $('#new_pwd').val();
         list.new_pwd_ok = $('#new_pwd_ok').val();
         if(list.real_name.length < 1) return $eb.message('error','请填写姓名');
            var url = "<?php echo Url('setAdminInfo'); ?>";
            $.ajax({
                url:url,
                data:{real_name:list.real_name,pwd:list.pwd,new_pwd:list.new_pwd,new_pwd_ok:list.new_pwd_ok},
                type:'post',
                dataType:'json',
                success:function (re) {
                    if(re.code == 400)
                        return $eb.message('error',re.msg);
                    else
                        return $eb.message('success',re.msg);
                }
            })
    })
</script>


</div>
</body>
</html>
