<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:69:"/data/wwwroot/app/application/admin/view/record/record/chart_cash.php";i:1557993193;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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
    
<script src="/public/static/plug/echarts.common.min.js"></script>

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
                    <div class="layui-carousel layadmin-carousel layadmin-shortcut" lay-anim="" lay-indicator="inside" lay-arrow="none" style="background:none">
                        <div class="layui-card-body">
                            <div class="layui-row layui-col-space10 layui-form-item">
                                <div class="layui-col-lg12">
                                    <label class="layui-form-label">创建时间:</label>
                                    <div class="layui-input-block" data-type="data" v-cloak="">
                                        <button class="layui-btn layui-btn-sm" type="button" v-for="item in dataList" @click="setData(item)" :class="{'layui-btn-primary':data!=item.value}">{{item.name}}</button>
                                        <button class="layui-btn layui-btn-sm" type="button" ref="time" @click="setData({value:'zd',is_zd:true})" :class="{'layui-btn-primary':data!='zd'}">自定义</button>
                                        <button type="button" class="layui-btn layui-btn-sm layui-btn-primary" v-show="showtime==true" ref="date_time"><?php echo $year['0']; ?> - <?php echo $year['1']; ?></button>
                                    </div>
                                </div>
                                <div class="layui-col-lg12">
                                    <div class="layui-input-block">
                                        <button @click="search" type="button" class="layui-btn layui-btn-sm layui-btn-normal">
                                            <i class="layui-icon layui-icon-search"></i>搜索</button>
                                        <button @click="refresh" type="reset" class="layui-btn layui-btn-primary layui-btn-sm">
                                            <i class="layui-icon layui-icon-refresh" ></i>刷新</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3" v-for="item in badge" v-cloak="">
            <div class="layui-card">
                <div class="layui-card-header">
                    {{item.name}}
                    <span class="layui-badge layuiadmin-badge" :class="item.background_color">{{item.field}}</span>
                </div>
                <div class="layui-card-body">
                    <p class="layuiadmin-big-font">{{item.count}}</p>
                    <p v-show="item.content!=''">
                        {{item.content}}
                        <span class="layuiadmin-span-color">{{item.sum}}<i :class="item.class"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm12">
            <div class="layui-card">
                <div class="layui-card-header">提现统计</div>
                <div class="layui-card-body layui-row">
                    <div class="layui-col-md12">
                        <div class="layui-btn-container" ref="echarts_list" style="height:400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-sm12">
            <div class="layui-card">
                <div class="layui-card-header">提现方式</div>
                <div class="layui-card-body layui-row">
                    <div class="layui-col-md12">
                        <div class="layui-btn-container" ref="echarts_price" style="height:400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>
<script>
    require(['vue'],function(Vue) {
        new Vue({
            el: "#app",
            data: {
                option: {},
                badge:[],
                dataList: [
                    {name: '全部', value: ''},
                    {name: '今天', value: 'today'},
                    {name: '本周', value: 'week'},
                    {name: '本月', value: 'month'},
                    {name: '本季度', value: 'quarter'},
                    {name: '本年', value: 'year'},
                ],
                data: '',
                myChart: {},
                showtime: false,
            },
            methods:{
                getBadgeList:function(){
                    var that=this;
                    layList.baseGet(layList.U({a:'getExtractHead',q:{data:this.data}}),function (rem) {
                        that.badge=rem.data;
                    });
                },
                getExtractData:function(){
                    var that=this;
                    var index=layList.layer.load(2,{shade: [0.3,'#fff']});
                    layList.baseGet(layList.U({a:'getExtractData',q:{data:this.data}}),function (rem) {
                        layList.layer.close(index);
                        var option=that.setoption(rem.data.chatrList,rem.data.legdata,rem.data.xdata,rem.data.zoom);
                        that.myChart.list.setOption(option);
                        var optionfenbu=that.setfenbuoption(rem.data.fenbudata,rem.data.cake);
                        that.myChart.price.setOption(optionfenbu);
                    },function () {
                        layList.layer.close(index);
                    })
                },
                setData:function(item){
                    var that=this;
                    if(item.is_zd==true){
                        that.showtime=true;
                        this.data=this.$refs.date_time.innerText;
                    }else{
                        this.showtime=false;
                        this.data=item.value;
                    }
                },
                setoption:function(seriesdata,legdata,xdata,dataZoom){
                    this.option={
                        title: {text:'提现金额和人数统计图'},
                        legend: {data:legdata,},
                        toolbox: {show : true,},
                        xAxis : [{type : 'category', data :xdata,}],
                        yAxis : [{type : 'value'}],
                        series:seriesdata,
                    };
                    if(dataZoom!=''){
                        this.option.dataZoom=[{startValue:dataZoom},{type:'inside'}];
                    }
                    return this.option;
                },
                setfenbuoption:function(seriesdata,xdata){
                    this.option={
                        title: {text:'提现方式分布图',left:'center'},
                        legend: {data:xdata,bottom:10,left:'center'},
                        tooltip: {trigger: 'item'},
                        series:[{ type: 'pie', radius : '65%', center: ['50%', '50%'], selectedMode: 'single',data:seriesdata}],
                    };
                    return this.option;
                },
                search:function(){
                    this.getExtractData();
                },
                refresh:function () {
                    this.data='';
                    this.getExtractData();
                },
                setChart:function(name,myChartname){
                    this.myChart[myChartname]=echarts.init(name);
                },
            },
            mounted:function () {
                this.setChart(this.$refs.echarts_list,'list');
                this.setChart(this.$refs.echarts_price,'price');
                this.getBadgeList();
                this.getExtractData();
                var that=this;
                layList.laydate.render({
                    elem:this.$refs.date_time,
                    trigger:'click',
                    eventElem:this.$refs.time,
                    range:true,
                    change:function (value) {
                        that.data=value;
                    }
                });
            }
        })
    })
</script>




</div>
</body>
</html>
