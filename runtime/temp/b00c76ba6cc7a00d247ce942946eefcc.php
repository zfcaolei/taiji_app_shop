<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\setting\system_group\edit.php";i:1556184114;s:72:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<link rel="stylesheet" href="/public/system/css/main.css">
<link rel="stylesheet" href="/public/static/css/animate.css">
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
<script>
    $eb = parent._mpApi;
    if(!$eb) top.location.reload();
</script>
    <title><?php echo $title; ?></title>
</head>
<body>
<div id="form-add" class="mp-form" v-cloak="">
    <i-Form :model="formData" :label-width="80" >
        <i-input v-model="formData.id" type="hidden" placeholder="请输入数据组名称"></i-input>
        <Form-Item label="数据组名称">
            <i-input v-model="formData.name" placeholder="请输入数据组名称"></i-input>
        </Form-Item>
        <Form-Item label="数据字段">
            <i-input v-model="formData.config_name" placeholder="请输入数据字段例如：site_url"></i-input>
        </Form-Item>
        <Form-Item label="数据组简介">
            <i-input v-model="formData.info" placeholder="请输入数据组简介"></i-input>
        </Form-Item>
        <Form-Item v-for="(item, index) in formData.typelist" :label="'字段' + (index+1)">
            <row type="flex" ref="typelist" align="middle">
                <i-col span="10">
                    <row>
                        <i-col span="23">
                            <Form-Item>
                                <i-input :placeholder="item.name.placeholder" v-model="item.name.value"></i-input>
                            </Form-Item>
                        </i-col>
                    </row>
                    <row>
                    <i-col span="23">
                        <Form-Item>
                            <i-input :placeholder="item.title.placeholder" v-model="item.title.value"></i-input>
                        </Form-Item>
                    </i-col>
                    </row>
                    <row>
                    <i-col span="23">
                        <Form-Item>
                            <i-select :placeholder="item.type.placeholder" v-model="item.type.value">
                                <i-option value="input">文本框</i-option>
                                <i-option value="textarea">多行文本框</i-option>
                                <i-option value="radio">单选框</i-option>
                                <i-option value="checkbox">多选框</i-option>
                                <i-option value="select">下拉选择</i-option>
                                <i-option value="upload">单图</i-option>
                                <i-option value="uploads">多图</i-option>
                            </i-select>
                        </Form-Item>
                    </i-col>
                    </row>
                </i-col>
                <i-col span="12">
                    <Form-Item>
                        <i-input type="textarea" rows="4" :placeholder="item.param.placeholder" v-model="item.param.value"></i-input>
                    </Form-Item>
                </i-col>
                <i-col span="2" style="display:inline-block; text-align:right;">
                    <i-button type="primary" icon="close-round" @click="removeType(index)"></i-button>
                </i-col>
                </row>
            </row>
        </Form-Item>
        <Form-Item><i-button type="primary" @click="addType">添加字段</i-button></Form-Item>
        <Form-Item :class="'add-submit-item'">
            <i-Button :type="'primary'" :html-type="'submit'" :size="'large'" :long="true" @click.prevent="submit">提交</i-Button>
        </Form-Item>
    </i-Form>
</div>
<script>
    $eb = parent._mpApi;
    mpFrame.start(function(Vue){
        new Vue({
            el:"#form-add",
            data:{
                formData:{
                    id: '<?php echo $Groupinfo['id']; ?>',
                    name: '<?php echo $Groupinfo['name']; ?>',
                    config_name: '<?php echo $Groupinfo['config_name']; ?>',
                    typelist: <?php echo $Groupinfo['fields']; ?>,
                    info:'<?php echo $Groupinfo['info']; ?>'
                }
            },
            methods:{
                addType: function(){
                    this.formData.typelist.push({
                        name: {
                            placeholder: "字段名称：姓名",
                            value: ''
                        },
                        title: {
                            placeholder: "字段配置名：name",
                            value: ''
                        },
                        type: {
                            placeholder: "字段类型",
                            value: ''
                        },
                        param: {
                            placeholder: "参数方式例如:\n1=白色\n2=红色\n3=黑色",
                            value: ''
                        }
                    })
                },
                removeType: function(index){
                    this.formData.typelist.splice(index,1);
                },
                submit: function(){
                    $eb.axios.post("<?php echo $save; ?>",this.formData).then((res)=>{
                        if(res.status && res.data.code == 200)
                    return Promise.resolve(res.data);
                    else
                    return Promise.reject(res.data.msg || '添加失败,请稍候再试!');
                }).then((res)=>{
                        $eb.message('success',res.msg || '操作成功!');
                    $eb.closeModalFrame(window.name);
                }).catch((err)=>{
                        this.loading=false;
                    $eb.message('error',err);
                });
                }
            }
        });
    });
</script>
</body>
