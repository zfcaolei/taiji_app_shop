<?php
namespace app\api\controller\v1;


use app\admin\model\store\StoreVedioImgRelation;
use app\admin\model\vedio\Pic;
use app\api\controller\Auth;
use app\routine\model\store\StoreProductAttr;
use think\Request;

class Vedio extends Auth{

    public function Lists(Request $request)
    {
        $data =[];
        $type = $request->get('type');  //类型  1=>视频 0=>图片
        $user_id = $this->user->id;
        if ($type == 1){
            $VedioModel = new \app\admin\model\vedio\Vedio();
            $data = $VedioModel->GetLists($user_id,$type);
        }else{
            $PicModel = new Pic();
            $data = $PicModel->GetLists($user_id,$type);
        }
        return show(1, 'success',$data, 200);

    }


    public function Details(Request $request)
    {
        $type = $request->get('type'); //类型  1=>视频 0=>图片
        $id = $request->get('id');
        $uid = $this->user->id;
        if (empty($id)){
            return show(config('code.error'), '参数错误', [], 400);
        }
        $VedioImgRelation = new StoreVedioImgRelation();
        $VedioImgRelationData = $VedioImgRelation -> IsUidCollect($uid,$type,$id);

        if ($type == 1){
            $VedioModel = new \app\admin\model\vedio\Vedio();
            $data = $VedioModel->getOneData($id);
            $data['is_collect'] = empty($VedioImgRelationData) ? 0 : 1;
            $data['collect_id'] = $VedioImgRelationData;
        }else{
            $PicModel = new Pic();
            $data = $PicModel->getOneData($id);
            $data['is_collect'] = empty($VedioImgRelationData) ? 0 : 1;
            $data['collect_id'] = $VedioImgRelationData;
        }
        return show(1, 'success',$data, 200);
    }




}