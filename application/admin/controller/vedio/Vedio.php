<?php

namespace app\admin\controller\vedio;

use app\admin\controller\AuthController;
use app\admin\model\article\Article as ArticleModel;
use app\admin\model\article\ArticleCategory as ArticleCategoryModel;
use app\admin\model\system\Express as ExpressModel;
use app\admin\model\system\SystemConfig as ConfigModel;

use app\common\lib\Fun;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use service\FormBuilder as Form;
use app\admin\model\store\StoreProductAttr;
use app\admin\model\store\StoreProductAttrResult;
use app\admin\model\store\StoreProductRelation;
use app\admin\model\system\SystemConfig;
use service\JsonService;
use service\JsonService as Json;



use service\PHPTreeService as Phptree;
use think\Exception;
use think\File;
use traits\CurdControllerTrait;
use service\UtilService as Util;

use service\UploadService as Upload;
use think\Request;
use app\admin\model\store\StoreCategory as CategoryModel;
use app\admin\model\store\StoreProduct as ProductModel;
use think\Url;

use app\admin\model\system\SystemAttachment;
require_once EXTEND_PATH.'qiniu/autoload.php';

/**
 * 视频管理
 * Class StoreProduct
 * @package app\admin\controller\store
 */
class Vedio extends AuthController
{

    /*
     * 视频列表页面
     */
    public function index(){
        $where = Util::getMore([
            ['status',''],
            ['vedio_name',''],
        ],$this->request);
        $this->assign('where',$where);

        $this->assign(\app\admin\model\vedio\Vedio::systemPage($where));
        return $this->fetch();
    }



    /*
     * 创建视频页面数据显示
     */
    public function create(Request $request){
        $type = input('type')!=0?input('type'):0;
        $tab_id = 16;
        if(!$tab_id) $tab_id = 1;
        $this->assign('tab_id',$tab_id);
        $list = ConfigModel::getAll($tab_id);
        if($type==3){//其它分类
            $config_tab = null;
        }else{
            $config_tab = [["value"=> 1,"label"=>  "视频添加" ,"icon"=> "cog" ,"type"=> 0]] ;

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

        $id = $request->param('id',0);
        $res  = \app\admin\model\vedio\Vedio::get($id);
        $this->assign('res',$res);
        $this->assign('id',$id);

        return $this->fetch();
    }




    /*
     * 创建视频操作
     */
    public function Mag(Request $request)
    {
        $id = $request->param('id');
        $post = $request->post();

        // 用于签名的公钥和私钥
        $accessKey = '_g0MZcoZWZm49rr9NRWvMEwc3bPC09G4Yrffld0o';
        $secretKey = '7ggDwgqb5jALg68Nl6QjHc5ZKA6OZINOM_nBh0_K';

        // 初始化签权对象
        if (empty($id)) {
            if (!$_FILES['vedio_file']['tmp_name']) {
                $this->error('视频不能为空', null, [], 1);
            }
        }else{
            if (empty($post['vedio_file'][0])) {
                $this->error('视频不能为空', null, [], 1);
            }
        }


        if ($_FILES['vedio_file']['tmp_name']) {

            $auth = new Auth($accessKey, $secretKey);
            $bucket = 'tjkj';//存储空间
            $token = $auth->uploadToken($bucket);
            $uploadMgr = new UploadManager();
            $filePath = $_FILES['vedio_file']['tmp_name'];//'./php-logo.png';  //接收图片信息
            if ($_FILES['vedio_file']['type'] == 'video/mp4') {
                $key = 'video' . time() . '.mp4';
            } elseif ($_FILES['vedio_file']['type'] == 'audio/mp3') {
                $key = 'audio' . time() . '.mp3';
            } else {
                $key = 'png' . time() . '.png';
            }
           list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

        }
            $vedio_name = $request->post('vedio_name');
//
            if (empty($id)) {
                $model = new \app\admin\model\vedio\Vedio();
            }else{
                $model = \app\admin\model\vedio\Vedio::get($id);
            }
            $key = empty($ret['key']) ? $model->vedio_url : $ret['key'];
            $model->vedio_name = $vedio_name;
            $model->vedio_url = $key;
            $model->vedio_time = \app\admin\model\vedio\Vedio::GetVedioTime($key);
            $model->vedio_img = config('qn.url').'/'.$key.'?vframe/png/offset/1';
            $model->save();
            if (!$model->save()){
                $this->success('新增成功', 'vedio.vedio/index',[],1);
            }else{
                $this->error('新增失败');
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
            $model = \app\admin\model\vedio\Vedio::get($id);

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
            $model = \app\admin\model\vedio\Vedio::get($id);
            $model -> status =  $type;
            if ($model->save()){
                $this->success('修改成功', 'vedio.vedio/index',[],1);
            }else{
                $this->success('修改失败','vedio.vedio/index',[],1);
            }
        }catch (Exception $e){
            $this->error($e->getMessage());
        }

    }


//    /**
//     * 模板表单提交
//     * */
    public function view_upload(){

        if($_POST['type'] == 3){

            $res = Upload::file($_POST['file'],'config/file');
        }else{
            $res = Upload::Image($_POST['file'],'config/image');
        }
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



    public function test(){
        $url = config('qn.url').'/'.'video1558577663.mp4'.'?'.'avinfo';
        $fun = new Fun();
        $data = \Qiniu\json_decode($fun->http_request($url));
        $vedio_time = $data->streams[0]->duration;

    }

}




