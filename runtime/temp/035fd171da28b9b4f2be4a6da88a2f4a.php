<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\widget\images.php";i:1556184114;}*/ ?>
<!DOCTYPE html>
<!--suppress JSAnnotator -->
<html lang="zh-CN">
<head>
    <link href="/public/static/plug/layui/css/layui.css" rel="stylesheet">
    <script src="/public/static/plug/jquery-1.10.2.min.js"></script>
    <script src="/public/static/plug/layui/layui.js"></script>
</head>
<style>
    .layui-btn + .layui-btn{margin: 0;}
    .main{ margin: 12px 0;}
    .main-top{ border-bottom: 1px solid #e5e5e5;  height: 12px;  width: 100%;  position: fixed;  top: 0;  background-color: #FFFFFF;  z-index: 100;  }
    .main .left{max-width:125px; height:100%;width: 115px;border-right: 1px solid #e5e5e5;border-left: 1px solid #e5e5e5;float: left;}
    .main .left .left-top{position: fixed;padding: 10px 10px 0;height: 35px;border-bottom: 1px solid #e5e5e5; background-color: #eee;}
    .main .left .tabs-left{overflow-y: auto;height: 100%;width:115px;position: fixed;top:58px;border-right: 1px solid #e5e5e5;}
    .main ::-webkit-scrollbar{width: 3px;height: auto;background-color: #ddd;}
    .main ::-webkit-scrollbar-thumb {
        border-radius: 1px;
        -webkit-box-shadow: inset 0 0 6px rgba(255,255,255,.3);
        background-color: #333;
    }
    .main ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        border-radius: 1px;
        background: #e5e5e5;
    }
    .main .left .nav{margin:0;padding-bottom: 100px;}
    .main .left .nav li{padding: 4px;height: 22px;}
    .main .left .nav li.active{background-color: #293846;border-left: 2px solid #19AA8D;}
    .main .left .nav li.active a{color: #a7b1c2;}
    .main .left .nav li.child{padding: 2px;padding-left: 7px;}
    .main .right{width: calc(100% - 117px);float: right;}
    .main .right .right-top{position: fixed;background-color: #fff;  z-index: 1000;width: 100%;padding: 7px 10px 0;height: 38px;border-bottom: 1px solid #e5e5e5;border-top: 1px solid #e5e5e5;}
    .main .right .imagesbox{position: fixed;top:58px;min-height: 200px;height: calc(100% - 88px);;overflow-y: auto;}
    .main .right .imagesbox .image-item{position: relative;display: inline-block;  width: 112px;height: 112px;  border: 1px solid #ECECEC;background-color: #F7F6F6;  cursor: default;  margin: 10px 0 0 10px;padding: 5px;}
    .main .right .imagesbox .image-item img{width: 112px;height: 112px;}
    .main .right .imagesbox .on{border: 3px dashed #0092DC;padding: 3px;}
    .main .right .foot-tool{position: fixed;bottom: 0px;width: calc(100% - 117px);background-color:#fff;height: 30px;padding: 7px 10px 0;border-top: 1px solid #e5e5e5;}
    .main .right .foot-tool .page{padding: 0px 10px;float: right;}
    .main .right .foot-tool .page ul{width: 100%}
    .main .right .foot-tool .page li{float: left;margin: 0px;}
    .main .right .foot-tool .page .disabled span{background-color: #e6e6e6!important;  color: #bbb!important;  cursor: no-drop;padding: 0px 10px;  height: 30px;  line-height: 30px;  display: block;}
    .main .right .foot-tool .page .active span{background-color: #428bca;color: #fff;border-color: #428bca;padding: 0px 10px;  height:30px;  line-height: 30px;  display: block;}
    .main .right .foot-tool .page li a{border: 1px solid #e5e5e5;padding: 0px 10px;  height: 28px;  line-height: 28px;  display: block;}
</style>
<body>
<div class="main">
    <div class="main-top"></div>
    <div class="left">
        <div class="left-top">
            <button class="layui-btn layui-btn-primary layui-btn-xs" id="addcate" title="添加分类"><i class="layui-icon layui-icon-add-circle-fine"></i></button>
            <button class="layui-btn layui-btn-primary layui-btn-xs" id="editcate" title="编辑当前分类"><i class="layui-icon layui-icon-edit"></i></button>
            <button class="layui-btn layui-btn-primary layui-btn-xs" id="deletecate" title="删除当前分类"><i class="layui-icon layui-icon-delete"></i></button>
        </div>
        <div class="tabs-left">
            <ul class="nav nav-tabs">
                <li <?php if($pid == 0): ?> class="active" <?php endif; ?>><a href="<?php echo Url('index',array('pid'=>0,'fodder'=>\think\Request::instance()->param('fodder'),'big'=>\think\Request::instance()->param('big'))); ?>">所有分类</a></li>
                <?php if(is_array($typearray) || $typearray instanceof \think\Collection || $typearray instanceof \think\Paginator): $k = 0; $__LIST__ = $typearray;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($vo['id'] == $pid): ?>
                     <li class="active"><a href="<?php echo Url('index',array('pid'=>$vo['id'],'fodder'=>\think\Request::instance()->param('fodder'),'big'=>\think\Request::instance()->param('big'))); ?>"><?php echo $vo['name']; ?></a></li>
                <?php else: ?>
                     <li ><a href="<?php echo Url('index',array('pid'=>$vo['id'],'fodder'=>\think\Request::instance()->param('fodder'),'big'=>\think\Request::instance()->param('big'))); ?>"><?php echo $vo['name']; ?></a></li>
                <?php endif; if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($kk % 2 );++$kk;?>
                       <li class="child <?php if($voo['id'] == $pid): ?> active<?php endif; ?>">
                        <a href="<?php echo Url('index',array('pid'=>$voo['id'],'fodder'=>\think\Request::instance()->param('fodder'),'big'=>\think\Request::instance()->param('big'))); ?>"><?php if($kk == count($vo['child'])): ?>└<?php else: ?>├<?php endif; ?><?php echo $voo['name']; ?></a>
                        </li>
                    <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <div class="right">
        <div class="right-top">
            <button class="layui-btn layui-btn-sm layui-btn-primary"  id="moveimg">移动分类</button>
            <button class="layui-btn  layui-btn-sm layui-btn-primary" id="deleteimg">删除图片</button>
        </div>
        <div class="imagesbox">
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="image-item">
                <div class="image-delete" data-url="<?php echo Url('delete',array('att_id'=>$vo['att_id'])); ?>"></div>
                <?php if(\think\Request::instance()->param('small') == 1): ?>
                <img class="pic" src="<?php echo ltrim($vo['satt_dir'],'.'); ?>" id="<?php echo $vo['att_id']; ?>"/>
                <?php else: ?>
                <img class="pic" src="<?php echo ltrim($vo['att_dir'],'.'); ?>" id="<?php echo $vo['att_id']; ?>"/>
                <?php endif; ?>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="foot-tool">
            <button class="layui-btn layui-btn-sm"  id="upload">上传图片</button>
            <button class="layui-btn layui-btn-normal layui-btn-sm" id="ConfirmChoices">使用选中的图片</button>
<!--            <button class="layui-btn layui-btn-danger layui-btn-sm" id="close" >关闭</button>-->
            <div class="page"><?php echo $page; ?></div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    var pid = <?php echo $pid; ?>;//当前图片分类ID
    var parentinputname = '<?php echo \think\Request::instance()->param('fodder'); ?>';//父级input name
    var uploadurl = "<?php echo Url('upload',array('pid'=>$pid)); ?>"; //上传图片地址
    var deleteurl = "<?php echo Url('delete'); ?>";//删除图片地址
    var moveurl = "<?php echo Url('moveimg'); ?>";//移动图片地址
    var addcate = "<?php echo Url('addcate',array('id'=>$pid)); ?>";//添加图片分类地址
    var editcate = "<?php echo Url('editcate',array('id'=>$pid)); ?>";//编辑图片分类地址
    var deletecate = "<?php echo Url('deletecate'); ?>";//删除图片分类地址
</script>
<script src="/public/system/module/widget/images.js"></script>

