<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:76:"/data/wwwroot/app/application/admin/view/record/record/chart_combination.php";i:1557993193;s:61:"/data/wwwroot/app/application/admin/view/public/container.php";i:1557993192;s:62:"/data/wwwroot/app/application/admin/view/public/frame_head.php";i:1557993192;s:57:"/data/wwwroot/app/application/admin/view/public/style.php";i:1557993192;s:64:"/data/wwwroot/app/application/admin/view/public/frame_footer.php";i:1557993192;}*/ ?>
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
                                    <label class="layui-form-label">产品状态:</label>
                                    <div class="layui-input-block" v-cloak="">
                                        <button class="layui-btn layui-btn-sm" :class="{'layui-btn-primary':status!=item.value}" @click="setStatus(item)" type="button" v-for="item in statusList">{{item.name}}</button>
                                    </div>
                                </div>
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
                    <p>
                        {{item.content}}
                        <span class="layuiadmin-span-color">{{item.sum}}<i :class="item.class"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm12">
            <div class="layui-card">
                <div class="layui-card-header">图表展示:</div>
                <div class="layui-card-body layui-row">
                    <div class="layui-col-md12">
                        <div class="layui-btn-container" ref="echarts_list" id="echarts_list" style="height:400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6">
            <div class="layui-card">
                <div class="layui-card-header">销量排行　<span class="layui-badge layui-bg-orange">TOP10</span></div>
                <div class="layui-card-body">
                    <p class="layuiadmin-normal-font">商品销售总计：<span style="color:lightblue">{{SalesList.sum_count}}</span> 件 共计 <span style="color:coral">{{SalesList.sum_price}}</span>元</p>
                    <div class="layuiadmin-card-list" v-for="item in SalesList.list">
                        <span>{{item.store_name}}</span>
                        <div class="layui-progress layui-progress-big" lay-showpercent="yes">
                            <div class="layui-progress-bar" :class="item.class" :style="{'width':item.w+'%'}"><span class="layui-progress-text">{{item.p_count}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6">
            <div class="layui-card">
                <div class="layui-card-header">利润排行　<span class="layui-badge layui-bg-orange">TOP10</span></div>
                <div class="layui-card-body">
                    <p class="layuiadmin-normal-font">商品销售总计：<span style="color:lightblue">{{ProfityList.sum_count}}</span> 件 共计 <span style="color:coral">{{ProfityList.sum_price}}</span>元</p>
                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                        <thead>
                        <tr>
                            <th>商品名称</th>
                            <th>销量占比(%)</th>
                            <th>购买个数</th>
                            <th>利润(￥)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in ProfityList.list">
                            <td><span class="first">{{item.store_name}}</span></td>
                            <td><i class="layui-icon layui-icon-log"> {{item.w}}</i></td>
                            <td><span>{{item.p_count}}</span></td>
                            <td> {{item.sum_price}} <i class="layui-icon layui-icon-rmb"></i></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-sm4 layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">退货产品</div>
                    <div class="layui-card-body">
                        <table class="layui-table layuiadmin-page-table" lay-skin="line">
                            <thead>
                            <tr>
                                <th>商品名称</th>
                                <th>单价</th>
                                <th>退货数量</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in TuiPriesList">
                                <td><span class="first">{{item.store_name}}</span></td>
                                <td><i class="layui-icon layui-icon-rmb">{{item.sum_price}}</i></td>
                                <td><span>{{item.count}}</span></td>
                                <td><button type="button" class="layui-btn layui-btn-xs" @click="edit(item)"><i class="layui-icon layui-icon-edit"></i>编辑</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>
<script>
    require(['vue'],function(Vue){
        new Vue({
            el:"#app",
            data:{
                option:{},
                badge:[],
                SalesList:[],
                ProfityList:[],
                TuiPriesList:[],
                statusList:[
                    {name:'全部商品',value:''},
                    {name:'热销产品',value:2},
                    {name:'显示产品',value:3},
                    {name:'已删除产品',value:1},
                ],
                dataList:[
                    {name:'全部',value:''},
                    {name:'今天',value:'today'},
                    {name:'本周',value:'week'},
                    {name:'本月',value:'month'},
                    {name:'本季度',value:'quarter'},
                    {name:'本年',value:'year'},
                ],
                status:'',
                data:'',
                title:'拼团全部商品',
                count:0,
                myChart:{},
                model:1,
                showtime:false,
            },
            watch:{

            },
            methods:{
                info:function(){
                    var that=this;
                    var index=layList.layer.load(2,{shade: [0.3,'#fff']});
                    layList.baseGet(layList.Url({a:'get_combination_echarts_product',q:{type:this.status,data:this.data,model:this.model}}),function (res){
                        layList.layer.close(index);
                        that.badge=res.data.badge;
                        that.count=res.data.count;
                        var option=that.setoption(res.data.datetime,res.data.legdata,res.data.chatrList);
                        that.myChart.list.setOption(option);
                    },function () {
                        layList.layer.close(index);
                    });
                },
                edit:function(item){
                    $eb.createModalFrame('编辑',layList.U({c:'ump.store_combination',a:'edit',p:{id:item.id}}));
                },
                getSalesList:function(){
                    var that=this;
                    layList.baseGet(layList.Url({a:'get_combination_maxlist',q:{data:this.data,model:this.model}}),function (rem) {
                        that.SalesList=rem.data;
                    });
                },
                getProfityList:function(){
                    var that=this;
                    layList.baseGet(layList.Url({a:'get_combination_profity',q:{data:this.data,model:this.model}}),function (rem) {
                        that.ProfityList=rem.data;
                    });
                },
                getTuiPriesList:function(){
                    var that=this;
                    layList.baseGet(layList.Url({a:'get_combination_refund_list',q:{data:this.data}}),function (rem) {
                        that.TuiPriesList=rem.data;
                    });
                },
                setoption:function(xdata,legdata,seriesdata){
                    return this.option={
                        title: {text:this.title+'('+this.count+')'+'件',},
                        tooltip: {show: true},
                        legend: {data:legdata,},
                        xAxis : [{type : 'category', data :xdata,}],
                        yAxis : [{type : 'value'}],
                        series:seriesdata,
                    };
                },
                setChart:function(name,myChartname){
                    this.myChart[myChartname]=echarts.init(name);
                },
                setStatus:function (item){
                    this.status=item.value;
                    this.title=item.name;
                    this.info();
                },
                setData:function(item){
                    var that=this;
                    if(item.is_zd==true){
                        that.showtime=true;
                    }else{
                        this.showtime=false;
                        this.data=item.value;
                    }
                    that.info();
                },
                refresh:function () {
                    this.status='';
                    this.data='';
                    this.info();
                },
                search:function(){
                    this.info();
                }
            },
            mounted:function () {
                var that = this;
                this.setChart(this.$refs.echarts_list,'list');
                this.info();
                this.getSalesList();
                this.getProfityList();
                this.getLackList();
                this.getTuiPriesList();
                layList.laydate.render({
                    elem:this.$refs.date_time,
                    trigger:'click',
                    eventElem:this.$refs.time,
                    range:true,
                    change:function (value, date, endDate) {
                        that.data= value;
                        that.info();
                    }
                });
            }
        });
    })
</script>




</div>
</body>
</html>
