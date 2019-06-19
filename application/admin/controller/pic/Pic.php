<?php
namespace app\admin\controller\pic;
use app\admin\model\store\StoreCategory as CategoryModel;
use app\admin\model\store\StoreProduct as ProductModel;
use app\admin\model\user\UserPoint as UserPointModel;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use service\JsonService;


use think\Exception;
use think\Url;
use service\FormBuilder as Form;
use think\Request;
use service\UtilService as Util;
use service\JsonService as Json;
use service\UploadService as Upload;
use app\admin\controller\AuthController;
use app\admin\model\system\SystemConfig as ConfigModel;
require_once EXTEND_PATH.'qiniu/autoload.php';
class Pic extends AuthController
{
    public function Lists()
    {
        $where = Util::getMore([
            ['status',''],
            ['pic_name',''],
        ],$this->request);
        $this->assign('where',$where);

        $this->assign(\app\admin\model\vedio\Pic::systemPage($where));
        return $this->fetch();
    }



    /**
     * 基础配置
     * */
    public function index(){
        $type = input('type')!=0?input('type'):0;
        $tab_id = 17; //input('tab_id');
        if(!$tab_id) $tab_id = 1;
        $this->assign('tab_id',$tab_id);
        $list = ConfigModel::getAll($tab_id);
        if($type==3){//其它分类
            $config_tab = null;
        }else{
            $config_tab = [["value"=> 1,"label"=>  "图片添加" ,"icon"=> "cog" ,"type"=> 0]] ;
            foreach ($config_tab as $kk=>$vv){
                $arr = ConfigModel::getAll($vv['value'])->toArray();
                if(empty($arr)){
                    unset($config_tab[$kk]);
                }
            }
        }
        foreach ($list as $k=>$v){
            if(!is_null(json_decode($v['value'])))
                $list[$k]['value'] = json_decode($v['value'],true);
            if($v['type'] == 'upload' && !empty($v['value'])){
                if($v['upload_type'] == 1 || $v['upload_type'] == 3) $list[$k]['value'] = explode(',',$v['value']);
            }
        }
        $this->assign('config_tab',$config_tab);
        $this->assign('list',$list);

        $id = \request()->param('id',0);
        $res  = \app\admin\model\vedio\Pic::get($id);
        $this->assign('res',$res);
        $this->assign('id',$id);

        return $this->fetch();
    }
    /**
     * 基础配置  单个
     * @return mixed|void
     */
    public function index_alone(){
        $tab_id = input('tab_id');
        if(!$tab_id) return $this->failed('参数错误，请重新打开');
        $this->assign('tab_id',$tab_id);
        $list = ConfigModel::getAll($tab_id);
        foreach ($list as $k=>$v){
            if(!is_null(json_decode($v['value'])))
                $list[$k]['value'] = json_decode($v['value'],true);
            if($v['type'] == 'upload' && !empty($v['value'])){
                if($v['upload_type'] == 1 || $v['upload_type'] == 3) $list[$k]['value'] = explode(',',$v['value']);
            }
        }
        $this->assign('list',$list);
        return $this->fetch();
    }
    /**
     * 添加字段
     * */
    public function create(Request $request){
        $data = Util::getMore(['type',],$request);//接收参数
        $tab_id = !empty($request->param('tab_id'))?$request->param('tab_id'):1;
        $formbuider = array();
        switch ($data['type']){
            case 0://文本框
                $formbuider = ConfigModel::createInputRule($tab_id);
                break;
            case 1://多行文本框
                $formbuider = ConfigModel::createTextAreaRule($tab_id);
                break;
            case 2://单选框
                $formbuider = ConfigModel::createRadioRule($tab_id);
                break;
            case 3://文件上传
                $formbuider = ConfigModel::createUploadRule($tab_id);
                break;
            case 4://多选框
                $formbuider = ConfigModel::createCheckboxRule($tab_id);
                break;
        }
        $form = Form::make_post_form('添加字段',$formbuider,Url::build('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }
    /**
     * 保存字段
     * */
    public function save(Request $request){
        $data = Util::postMore([
            'menu_name',
            'type',
            'config_tab_id',
            'parameter',
            'upload_type',
            'required',
            'width',
            'high',
            'value',
            'info',
            'desc',
            'sort',
            'status',],$request);
        if(!$data['info']) return Json::fail('请输入配置名称');
        if(!$data['menu_name']) return Json::fail('请输入字段名称');
        if($data['menu_name']){
            $oneConfig = ConfigModel::getOneConfig('menu_name',$data['menu_name']);
            if(!empty($oneConfig)) return Json::fail('请重新输入字段名称,之前的已经使用过了');
        }
        if(!$data['desc']) return Json::fail('请输入配置简介');
        if($data['sort'] < 0){
            $data['sort'] = 0;
        }
        if($data['type'] == 'text'){
            if(!ConfigModel::valiDateTextRole($data)) return Json::fail(ConfigModel::getErrorInfo());
        }
        if($data['type'] == 'textarea'){
            if(!ConfigModel::valiDateTextareaRole($data)) return Json::fail(ConfigModel::getErrorInfo());
        }
        if($data['type'] == 'radio' || $data['type'] == 'checkbox' ){
            if(!$data['parameter']) return Json::fail('请输入配置参数');
            if(!ConfigModel::valiDateRadioAndCheckbox($data)) return Json::fail(ConfigModel::getErrorInfo());
            $data['value'] = json_encode($data['value']);
        }
        ConfigModel::set($data);
        return Json::successful('添加菜单成功!');
    }
    /**
     * @param Request $request
     * @param $id
     * @return \think\response\Json
     */
    public function update_config(Request $request, $id)
    {
        $type = $request->post('type');
        if($type =='text' || $type =='textarea'|| $type == 'radio' || ($type == 'upload' && ($request->post('upload_type') == 1 || $request->post('upload_type') == 3))){
            $value = $request->post('value');
        }else{
            $value = $request->post('value/a');
        }
        $data = Util::postMore(['status','info','desc','sort','config_tab_id','required','parameter',['value',$value],'upload_type'],$request);
        $data['value'] = json_encode($data['value']);
        if(!ConfigModel::get($id)) return Json::fail('编辑的记录不存在!');
        ConfigModel::edit($data,$id);
        return Json::successful('修改成功!');
    }

    /**
     * 修改是否显示子子段
     * @param $id
     * @return mixed
     */
    public function edit_cinfig($id){
        $menu = ConfigModel::get($id)->getData();
        if(!$menu) return Json::fail('数据不存在!');
        $formbuider = array();
        $formbuider[] = Form::input('menu_name','字段变量',$menu['menu_name'])->disabled(1);
//        $formbuider[] = Form::input('type','字段类型',$menu['type'])->disabled(1);
        $formbuider[] = Form::hidden('type',$menu['type']);
        $formbuider[] = Form::select('config_tab_id','分类',(string)$menu['config_tab_id'])->setOptions(ConfigModel::getConfigTabAll(-1));
        $formbuider[] = Form::input('info','配置名称',$menu['info'])->autofocus(1);
        $formbuider[] = Form::input('desc','配置简介',$menu['desc']);
        switch ($menu['type']){
            case 'text':
                $menu['value'] = json_decode($menu['value'],true);
                //输入框验证规则
                $formbuider[] = Form::input('value','默认值',$menu['value']);
                if(!empty($menu['required'])){
                    $formbuider[] = Form::number('width','文本框宽(%)',$menu['width']);
                    $formbuider[] = Form::input('required','验证规则',$menu['required'])->placeholder('多个请用,隔开例如：required:true,url:true');
                }
                break;
            case 'textarea':
                $menu['value'] = json_decode($menu['value'],true);
                //多行文本
                if(!empty($menu['high'])){
                    $formbuider[] = Form::textarea('value','默认值',$menu['value'])->rows(5);
                    $formbuider[] = Form::number('width','文本框宽(%)',$menu['width']);
                    $formbuider[] = Form::number('high','多行文本框高(%)',$menu['high']);
                }else{
                    $formbuider[] = Form::input('value','默认值',$menu['value']);
                }
                break;
            case 'radio':
                $menu['value'] = json_decode($menu['value'],true);
                $parameter = explode("\n",$menu['parameter']);
                $options = [];
                if($parameter){
                    foreach ($parameter as $v){
                        $data = explode("=>",$v);
                        $options[] = ['label'=>$data[1],'value'=>$data[0]];
                    }
                    $formbuider[] = Form::radio('value','默认值',$menu['value'])->options($options);
                }
                //单选和多选参数配置
                if(!empty($menu['parameter'])){
                    $formbuider[] = Form::textarea('parameter','配置参数',$menu['parameter'])->placeholder("参数方式例如:\n1=白色\n2=红色\n3=黑色");
                }
                break;
            case 'checkbox':
                $menu['value'] = json_decode($menu['value'],true)?:[];
                $parameter = explode("\n",$menu['parameter']);
                $options = [];
                if($parameter) {
                    foreach ($parameter as $v) {
                        $data = explode("=>", $v);
                        $options[] = ['label' => $data[1], 'value' => $data[0]];
                    }
                    $formbuider[] = Form::checkbox('value', '默认值', $menu['value'])->options($options);
                }
                //单选和多选参数配置
                if(!empty($menu['parameter'])){
                    $formbuider[] = Form::textarea('parameter','配置参数',$menu['parameter'])->placeholder("参数方式例如:\n1=白色\n2=红色\n3=黑色");
                }
                break;
            case 'upload':
                if($menu['upload_type'] == 1 ){
                    $menu['value'] = json_decode($menu['value'],true);
                    $formbuider[] =  Form::frameImageOne('value','图片',Url::build('admin/widget.images/index',array('fodder'=>'value')),(string)$menu['value'])->icon('image')->width('100%')->height('550px');
                }elseif ($menu['upload_type'] == 2 ){
                    $menu['value'] = json_decode($menu['value'],true)?:[];
                    $formbuider[] =  Form::frameImages('value','多图片',Url::build('admin/widget.images/index',array('fodder'=>'value')),$menu['value'])->maxLength(5)->icon('images')->width('100%')->height('550px')->spin(0);
                }else{
                    $menu['value'] = json_decode($menu['value'],true);
                    $formbuider[] =  Form::uploadFileOne('value','文件',Url::build('file_upload'))->name('file');
                }
                //上传类型选择
                if(!empty($menu['upload_type'])){
                    $formbuider[] = Form::radio('upload_type','上传类型',$menu['upload_type'])->options([['value'=>1,'label'=>'单图'],['value'=>2,'label'=>'多图'],['value'=>3,'label'=>'文件']]);
                }
                break;

        }
        $formbuider[] = Form::number('sort','排序',$menu['sort']);
        $formbuider[] = Form::radio('status','状态',$menu['status'])->options([['value'=>1,'label'=>'显示'],['value'=>2,'label'=>'隐藏']]);

        $form = Form::make_post_form('编辑字段',$formbuider,Url::build('update_config',array('id'=>$id)));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }
    /**
     * 删除子字段
     * @return \think\response\Json
     */
    public function delete_cinfig(){
        $id = input('id');
        if(!ConfigModel::del($id))
            return Json::fail(ConfigModel::getErrorInfo('删除失败,请稍候再试!'));
        else
            return Json::successful('删除成功!');
    }

    /**
     * 保存数据    true
     * */
    public function save_basics(){
        $request = Request::instance();

        if($request->isPost()){
            $file = request()->file('pic_url');
            $post = request()->post();

            if (empty($request->param('id'))) {
                if (empty($file)) {
                    $this->error('请上传图片');
                }
            }else{
                if (empty($post['pic_url'][0])) {
                    $this->error('请上传图片');
                }
            }

            if (empty($post['pic_name'])){
                $this->error('请填写图片名称');
            }

            if (empty($file) && !empty($request->param('id'))){
                $model = \app\admin\model\vedio\Pic::get($request->param('id'));
                $model -> pic_name = $post['pic_name'];
                $model -> pic_url =   $model -> pic_url;
                $model -> pic_qn_url =$model -> pic_qn_url;
                if($model -> save()){
                    $this->success('新增成功', 'pic.pic/lists',[],1);
                }else{
                    $this->error('新增失败');
                }
            }

            if (!empty($file)) {
                $filePath = $file->getRealPath();
                $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀

                // 上传到七牛后保存的文件名
                $key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;

                // 需要填写你的 Access Key 和 Secret Key
                $accessKey = '_g0MZcoZWZm49rr9NRWvMEwc3bPC09G4Yrffld0o';
                $secretKey = '7ggDwgqb5jALg68Nl6QjHc5ZKA6OZINOM_nBh0_K';
                // 构建鉴权对象
                    $auth = new Auth($accessKey, $secretKey);
                    // 要上传的空间
                    $bucket = 'tjkj';//存储空间
                    $token = $auth->uploadToken($bucket);
                    // 初始化 UploadManager 对象并进行文件的上传
                    $uploadMgr = new UploadManager();
                    // 调用 UploadManager 的 putFile 方法进行文件的上传
                    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
                    if ($err !== null) {
                        $this->error('新增失败');
                    }

                    if (!$request->param('id')) {
                        $model = new \app\admin\model\vedio\Pic();
                    }else{
                        $model = \app\admin\model\vedio\Pic::get($request->param('id'));
                    }
                    $model -> pic_name = $post['pic_name'];
                    $model -> pic_url =  $post['pic_url'][0];
                    $model -> pic_qn_url = $ret['key'];
                    if($model -> save()){
                        $this->success('新增成功', 'pic.pic/lists',[],1);
                    }else{
                        $this->error('新增失败');
                    }
            }
        }
    }


    /*
     * 删除视频
     */
    public function Delete(Request $request)
    {
        try{
            $data = [];
            $id = $request->param('id');
            $model = \app\admin\model\vedio\Pic::get($id);

            $model->is_del = 1;
            if ($model ->save()){
                $data['status'] = 200;
                $data['code'] = 200;
                $data['msg'] = '删除成功';
            }
        } catch (\Exception $e) {
            $data['msg'] = $e->getMessage();
        }
        return $data;
    }



    public function Hidden(Request $request)
    {
        try{
            $type = $request ->param('type');
            $id = $request->param('id');
            $model = \app\admin\model\vedio\Pic::get($id);
            $model -> status =  $type;
            if ($model->save()){
                $this->success('修改成功', 'pic.pic/lists',[],1);
            }else{
                $this->success('修改失败','pic.pic/lists',[],1);
            }
        }catch (Exception $e){
            $this->error($e->getMessage());
        }

    }

    /**
     * 模板表单提交
     * */
    public function view_upload(){
        if($_POST['type'] == 3){
            $res = Upload::file($_POST['file'],'config/file');
        }else{
            $res = Upload::Image($_POST['file'],'config/image');
        }
         $id = \request()->param('id');

        if(!$res->status) return Json::fail($res->error);
        return Json::successful('上传成功!',['url'=>$res->dir]);
    }
    /**
     * 文件上传
     * */
    public function file_upload(){
        $res = Upload::file($_POST['file'],'config/file');
        if(!$res->status) return Json::fail($res->error);
        return Json::successful('上传成功!',['url'=>$res->dir]);
    }


    /**
     * 获取文件名
     * */
    public function getImageName(){
        $request = Request::instance();
        $post = $request->post();
        $src = $post['src'];
        $data['name'] = basename($src);
        exit(json_encode($data));
    }
    /**
     * 删除原来图片
     * @param $url
     */
    public function rmPublicResource($url)
    {
        $res = Util::rmPublicResource($url);
        if($res->status)
            return $this->successful('删除成功!');
        else
            return $this->failed($res->msg);
    }


    public function test()
    {

        $this->assign([
            'is_layui'=>true,
            'year'=>getMonth('y'),
        ]);
        return $this->fetch();
    }

    //异步获取积分列表
    public function getponitlist(){
        $where = Util::getMore([
            ['start_time',''],
            ['end_time',''],
            ['nickname',''],
            ['page',1],
            ['limit',10],
        ]);
        return JsonService::successlayui(UserPointModel::getpointlist($where));
    }




}
