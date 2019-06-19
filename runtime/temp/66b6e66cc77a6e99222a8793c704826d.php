<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:58:"/data/wwwroot/app/application/admin/view/pic/pic/index.php";i:1558938207;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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
    
<link href="/public/system/frame/css/plugins/iCheck/custom.css" rel="stylesheet">
<script src="/public/system/plug/validate/jquery.validate.js"></script>
<script src="/public/system/frame/js/plugins/iCheck/icheck.min.js"></script>
<script src="/public/system/frame/js/ajaxfileupload.js"></script>
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
    .file{
        background-color:#676a6c;
        border: none;
    }
    .deleteimg{position: absolute;
        right: 0%;
        top: 0%;
        cursor: pointer;
        background-color:#676a6c;
        color: #fff;
        width: 18px;
        text-align: center;}
</style>

</head>
<body class="gray-bg">
<!--演示地址https://daneden.github.io/animate.css/?-->
<div class="wrapper wrapper-content animated ">

<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">

            <div class="tabs-container ibox-title">
                <ul class="nav nav-tabs">
                    <?php if(is_array($config_tab) || $config_tab instanceof \think\Collection || $config_tab instanceof \think\Paginator): $i = 0; $__LIST__ = $config_tab;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['value'] == $tab_id): ?>
                    <li class="active"><a href="<?php echo Url('index',array('tab_id'=>$vo['value'],'type'=>$vo['type'])); ?>"><i class="fa fa-<?php echo $vo['icon']; ?>"></i><?php echo $vo['label']; ?></a></li>
                    <?php else: ?>
                    <li><a href="<?php echo Url('index',array('tab_id'=>$vo['value'],'type'=>$vo['type'])); ?>"><i class="fa fa-<?php echo $vo['icon']; ?>"></i><?php echo $vo['label']; ?></a></li>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <div class="tab-content">
                    <div class="<!--ibox-content--> p-m m-t-sm">
                        <form method="post" class="form-horizontal" id="signupForm" action="<?php echo Url('save_basics',['id'=>$id]); ?>" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $tab_id; ?>" name="tab_id"/>
                            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['config_tab_id'] == $tab_id): ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" <?php if($vo['type'] == 'radio'): ?>style="padding-top: 0;"<?php endif; ?>><?php echo $vo['info']; ?></label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php switch($vo['type']): case "text": ?><!-- 文本框-->
                                            <input type="<?php echo $vo['type']; ?>" class="form-control" name="<?php echo $vo['menu_name']; ?>" value="<?=empty($res['pic_name']) ?  '' : $res['pic_name']?>" validate="<?php echo $vo['required']; ?>" style="width: <?php echo $vo['width']; ?>%"/>
                                            <?php break; case "textarea": ?><!--多行文本框-->
                                            <textarea name="<?php echo $vo['menu_name']; ?>" cols="<?php echo $vo['width']; ?>" rows="<?php echo $vo['high']; ?>" class="form-control" style="width: <?php echo $vo['width']; ?>%"><?php echo $vo['value']; ?></textarea>
                                            <?php break; case "checkbox": ?><!--多选框-->
                                            <?php
                                            $parameter = array();
                                            $option = array();
                                            if($vo['parameter']){
                                                $parameter = explode("\n",$vo['parameter']);
                                                foreach ($parameter as $k=>$v){
                                                    $option[$k] = explode('=>',$v);
                                                }
//                                                dump($parameter);
                                                //                                            exit();
                                            }
                                            $checkbox_value = $vo['value'];
                                            if(!is_array($checkbox_value)) $checkbox_value = explode("\n",$checkbox_value);
                                            //                                        dump($checkbox_value);
                                            //                                        exit();
                                            if(is_array($option) || $option instanceof \think\Collection || $option instanceof \think\Paginator): $k = 0; $__LIST__ = $option;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($k % 2 );++$k;if(in_array($son[0],$checkbox_value)): ?>
                                            <label class="checkbox-inline i-checks">
                                                <input type="checkbox" value="<?php echo $son['0']; ?>" name="<?php echo $vo['menu_name']; ?>[]" checked="checked"><?php echo $son['1']; ?></label>
                                            <?php else: ?>
                                            <label class="checkbox-inline i-checks">
                                                <input type="checkbox" value="<?php echo $son['0']; ?>" name="<?php echo $vo['menu_name']; ?>[]"><?php echo $son['1']; ?></label>
                                            <?php endif; endforeach; endif; else: echo "" ;endif; break; case "radio": ?><!--单选按钮-->
                                            <?php
                                            $parameter = array();
                                            $option = array();

                                            if($vo['parameter']){
                                                $parameter = explode("\n",$vo['parameter']);
                                                foreach ($parameter as $k=>$v){
                                                    $option[$k] = explode('=>',$v);
                                                }
                                            }
                                            if(is_array($option) || $option instanceof \think\Collection || $option instanceof \think\Paginator): $i = 0; $__LIST__ = $option;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($i % 2 );++$i;if($son[0] == $vo['value']): ?>
                                            <div class="radio i-checks checked" style="display:inline">
                                                <label class="" style="padding-left: 0;">
                                                    <div class="iradio_square-green " style="position: relative;">
                                                        <input type="radio" checked="checked" value="<?php echo $son['0']; ?>" name="<?php echo $vo['menu_name']; ?>" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    <i></i> <?php echo $son['1']; ?>
                                                </label>
                                            </div>
                                            <?php else: ?>
                                            <div class="radio i-checks" style="display:inline">
                                                <label class="" style="padding-left: 0;">
                                                    <div class="iradio_square-green" style="position: relative;">
                                                        <input type="radio" value="<?php echo $son['0']; ?>" name="<?php echo $vo['menu_name']; ?>" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    <i></i> <?php echo $son['1']; ?>
                                                </label>
                                            </div>
                                            <?php endif; endforeach; endif; else: echo "" ;endif; break; case "upload": ?><!--文件上传-->
                                            <?php
                                            $img_image = $vo['value'];
                                            $num_img = 0;
                                            if(!empty($img_image)){
                                                $num_img = 1;
                                            }
                                            ?>
                                            <!--文件--><?php if($vo['upload_type'] == 3): ?>
                                            <button class="btn btn-w-m btn-primary flag" type="button" data-name="<?php echo $vo['menu_name']; ?>"><i class="fa fa-upload"></i>添加文件</button>

                                            <div style="display: inline-flex;">
                                                <input type="file" class="<?php echo $vo['menu_name']; ?>_1" name="<?php echo $vo['menu_name']; ?>" style="display: none;" data-name="<?php echo $vo['menu_name']; ?>" id="<?php echo $vo['menu_name']; ?>" data-type = "<?php echo $vo['upload_type']; ?>" />
                                                <?php if($num_img < 1): ?>
                                                <div class="file-box">
                                                    <div class="file <?php echo $vo['menu_name']; ?>">
                                                    </div>
                                                </div>
                                                <?php else: if(is_array($vo['value']) || $vo['value'] instanceof \think\Collection || $vo['value'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>

                                                <div class="file-box">
                                                    <div class="file <?php echo $vo['menu_name']; ?>" style="position: relative;">
                                                        <a href="http://<?php echo $_SERVER['SERVER_NAME'].$img;?>" target="_blank">
                                                            <span class="corner"></span>
                                                            <div class="icon">
                                                                <i class="fa fa-file"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <?php
                                                                //显示带有文件扩展名的文件名
                                                                echo basename($img);
                                                                ?>
                                                            </div>
                                                        </a>
                                                        <div data-name="<?php echo $vo['menu_name']; ?>" data-image="<?php echo $img; ?>" class="deleteimg" onclick="delPic(this)" title="删除">×</div>
                                                        <input type="hidden" name="<?php echo $vo['menu_name']; ?>[]" value="<?php echo $img; ?>">
                                                    </div>
                                                </div>
                                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                                <div class="clearfix"></div>
                                            </div>
                                            <!--多图--><?php elseif($vo['upload_type'] == 2): ?>
                                            <div style="margin-top: 20px;">
                                                <input type="file" class="<?php echo $vo['menu_name']; ?>_1" name="<?php echo $vo['menu_name']; ?>" style="display: none;" data-name="<?php echo $vo['menu_name']; ?>" id="<?php echo $vo['menu_name']; ?>" data-type = "<?php echo $vo['upload_type']; ?>" />
                                                <button class="btn btn-w-m btn-primary flag" type="button" data-name="<?php echo $vo['menu_name']; ?>"><i class="fa fa-upload"></i>添加图片</button>
                                                <!--                                                    <span class="flag" style="margin-top: 5px;width: 86px;height: 27px;border-radius: 6px;cursor:pointer;padding: .5rem 1rem;background-color: #18a689;color: #fff;text-align: center;" data-name="<?php echo $vo['menu_name']; ?>" >添加图片</span>-->
                                                <div class="attachment upload_image_<?php echo $vo['menu_name']; ?>" style="display:block;margin:20px 0 5px -44px">
                                                    <?php if(is_array($vo['value']) || $vo['value'] instanceof \think\Collection || $vo['value'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
                                                    <div class="file-box">
                                                        <div class="file <?php echo $vo['menu_name']; ?>" style="position: relative;">
                                                            <span class="corner"></span>
                                                            <div class="image open_image">
                                                                <img alt="image" class="img-responsive" data-image="<?php echo $img; ?>" src="<?php echo $img; ?>" style="width:100%;height:100%;cursor: pointer" >
                                                            </div>
                                                            <div class="file-name">
                                                                <?php
                                                                //显示带有文件扩展名的文件名
                                                                echo basename($img);
                                                                ?>
                                                            </div>
                                                            <div data-name="<?php echo $vo['menu_name']; ?>" data-image="<?php echo $img; ?>" class="deleteimg" onclick="delPic(this)" title="删除">×</div>
                                                            <input type="hidden" name="<?php echo $vo['menu_name']; ?>[]" value="<?php echo $img; ?>">
                                                        </div>
                                                    </div>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <!--单图--><?php else: ?>
                                            <div style="display: inline-flex;">
                                                <input type="file" class="<?php echo $vo['menu_name']; ?>_1" name="<?php echo $vo['menu_name']; ?>" style="display: none;" data-name="<?php echo $vo['menu_name']; ?>" id="<?php echo $vo['menu_name']; ?>" data-type = "<?php echo $vo['upload_type']; ?>" />
                                                <div class="flag" style="width: 100px;height: 80px;background-image:url('/public/system/module/wechat/news/images/image.png');cursor: pointer"  data-name="<?php echo $vo['menu_name']; ?>" >
                                                </div>
                                                <?php if($num_img < 1): ?>
                                                <div class="file-box">
                                                    <div class="<?php echo $vo['menu_name']; ?>">
                                                    </div>
                                                </div>
                                                <?php else: if(is_array($vo['value']) || $vo['value'] instanceof \think\Collection || $vo['value'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
                                                <div class="file-box">
                                                    <div class="<?php echo $vo['menu_name']; ?>">
                                                        <div style="position: relative;" class="file">
                                                            <div class="image open_image">
                                                                <img alt="image" class="img-responsive" data-image="<?php echo $img; ?>" src="<?=empty($res['pic_url']) ?  '' : $res['pic_url']?>" style="width: 100%;height: 100%;cursor: pointer">
                                                            </div>
                                                            <div data-name="<?php echo $vo['menu_name']; ?>" data-image="<?php echo $img; ?>" class="deleteimg" onclick="delPic(this)" title="删除">×</div>
                                                            <input type="hidden" name="<?php echo $vo['menu_name']; ?>[]" value="<?php echo $img; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                <div class="clearfix"></div>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; break; endswitch; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> <?php echo $vo['desc']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                        <div class="hr-line-dashed"></div>-->
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            <div class="form-group" style="text-align: center;">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $eb = parent._mpApi;
    $().ready(function() {
        $("#signupForm").validate();
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.flag').on('click',function(){
            $('.'+$(this).data('name')+'_1').trigger('click');
            change_upload($(this).data('name'));
        });
        function change_upload(_this_name) {
            $('.'+_this_name+'_1').on('change',function(){
                ajaxFileUpload(this);
            });
        }
    });
    /**
     * 添加文件
     * */
    function getHtmlFlie(menu_name,html_src) {
        html_file = '';
        if(html_src.length < 1){
            return html_file;
        }
        html_file += '<a href="http://'+window.location.host+html_src+'" target="_blank">';
        html_file += '<span class="corner"></span>';
        html_file += '<div class="icon">';
        html_file += '<i class="fa fa-file"></i>';
        html_file += '</div>';
        html_file += '<div class="file-name">';
        $.ajax({
            url:"<?php echo url('getImageName'); ?>",
            data:'src='+html_src,
            type:'post',
            async:false,
            dataType:'json',
            success:function (re) {
                html_file += re.name;
            }
        })
        html_file += '</div>';
        html_file += '</a>';
        html_file += '<div data-name="'+menu_name+'" data-image="'+html_src+'"  class="deleteimg" onclick="delPic(this)" title="删除">×</div>';
        html_file += '<input type="hidden" name="'+menu_name+'[]" value="'+html_src+'">';
        return html_file;
    }
    /**
     * 多图上传html 处理
     * */
    function getHtmlOrthe(menu_name,html_src) {
        html_order = '';
        if(html_src.length < 1){
            return html_order;
        }
        html_order += '<div class="file-box">';
        html_order += '<div class="file '+menu_name+'" style="position: relative">';
        html_order += '<span class="corner"></span>';
        html_order += '<div class="image open_image">';
        html_order += '<img alt="image" class="img-responsive" data-image="'+html_src+'" src="'+html_src+'" style="width:100%;height:100%;cursor: pointer">';
        html_order += '</div>';
        html_order += '<div class="file-name">';
        $.ajax({
            url:"<?php echo url('getImageName'); ?>",
            data:'src='+html_src,
            type:'post',
            async:false,
            dataType:'json',
            success:function (re) {
                html_order += re.name;
            }
        })
        html_order += '</div>';
        html_order += '<div data-name="'+menu_name+'" data-image="'+html_src+'" class="deleteimg" onclick="delPic(this)" title="删除">×</div>';
        html_order += '<input type="hidden" name="'+menu_name+'[]" value="'+html_src+'">';
        html_order += '</div>';
        html_order += '</div>';
        return html_order;
    }
    /**
     * 单图上传html处理
     * */
    function getHtml(menu_name,html_src) {
        html_one = '';
        if(html_src.length < 1){
            return html_one;
        }
        html_one += '<div style="position: relative;" class="file">'
        html_one += '<span class="corner"></span>';
        html_one += '<div class="image open_image">';
        html_one += '<img alt="image" class="img-responsive" data-image="'+html_src+'" src="'+html_src+'" style="width:100%;height:100%;cursor: pointer">';
        html_one += '</div>';
        html_one += '<div class="file-name">';
        $.ajax({
            url:"<?php echo url('getImageName'); ?>",
            data:'src='+html_src,
            type:'post',
            async:false,
            dataType:'json',
            success:function (re) {
                html_one += re.name;
            }
        })
        html_one += '</div>';
        html_one += '<div data-name="'+menu_name+'" data-image="'+html_src+'"  class="deleteimg" onclick="delPic(this)" title="删除">×</div>';
        html_one += '<input type="hidden" name="'+menu_name+'[]" value="'+html_src+'">';
        html_one += '</div>'
        return html_one;
    }

    function ajaxFileUpload(is) {
        bool_upload_num = $(is).data('type');
        $.ajaxFileUpload({
            url: "<?php echo url('view_upload'); ?>",
            data:{file: $(is).data('name'),type:bool_upload_num},
            type: 'post',
            secureuri: false, //一般设置为false
            fileElementId: $(is).data('name'), // 上传文件的id、name属性名
            dataType: 'json', //返回值类型，一般设置为json、application/json
            success: function(data, status, e){
                console.log(data);
                if(data.code == 200){
                    if(bool_upload_num == 2){
                        getHtmlOrthe($(is).data('name'),data.data.url);
                        $('.upload_image_'+$(is).data('name')).append(html_order);
                    }else if(bool_upload_num == 1){
                        getHtml($(is).data('name'),data.data.url);
                        $('.'+$(is).data('name')).empty();
                        $('.'+$(is).data('name')).append(html_one);
                    }else if(bool_upload_num == 3){
                        getHtmlFlie($(is).data('name'),data.data.url);
                        $('.'+$(is).data('name')).empty();
                        $('.'+$(is).data('name')).append(html_file);
                    }else{}
                    $eb.message('success',data.msg);
                }else{
                    $eb.message('error',data.msg);
                }
                $('.'+$(is).data('name')).on('change',function(){ ajaxFileUpload(this);})
            },
            error: function(data, status, e){
                $('.'+$(is).data('name')).on('change',function(){ ajaxFileUpload(this);})
            }
        });
    }
    $('.del_upload_one');
    function delPic(_this) {
        if(!confirm('确认删除?')) return false;
        p = $(_this).parents('.'+$(_this).data('name'));
        p.empty();
        var image = $(_this).data('image');
        url = "<?php echo Url('rmPublicResource'); ?>";
        $.ajax({
            url:url,
            data:'url='+image,
            type:'get',
            success:function (re) {
                if(re.code == 200){
                    $eb.message('success',re.msg);
                }else{
                    $eb.message('error',re.msg);
                }
            }
        })
    }
    $(document).on('click','.open_image',function (e) {
        var image = $(".open_image img").data('image');
        $eb.openImage(image);
    })
</script>


</div>
</body>
</html>
