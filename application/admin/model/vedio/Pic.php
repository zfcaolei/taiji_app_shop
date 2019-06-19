<?php

/**

 *

 * @author: xaboy<365615158@qq.com>

 * @day: 2017/11/02

 */

namespace app\admin\model\vedio;

use app\admin\model\store\StoreVedioImgRelation;
use app\admin\model\system\SystemAdmin;
use think\Model;
use traits\ModelTrait;
use basic\ModelBasic;
use think\Db;


class Pic extends Model {


    use ModelTrait;
    protected $table = 'eb_pic';




    /**
     * 获取系统分页数据   分类
     * @param array $where
     * @return array
     */
    public static function systemPage($where = array()){
        $model = new self;
        if($where['pic_name'] !== '') $model = $model->where('pic_name','LIKE',"%$where[pic_name]%");
        if($where['status'] !== '') $model = $model->where('status',$where['status']);
        $model = $model->where('is_del',0);

        return self::page($model,[],[],10);
    }


    public function GetLists($uid,$type){
        $list = self::where(['status' => 1])
            ->field(['id', 'pic_qn_url', 'pic_name'])
            ->paginate(10);

        if (!empty($list)){
            $video_img_collect = new StoreVedioImgRelation();
            foreach ($list as $key => $val){
                $list[$key]['pic_qn_url'] = 'http://qn.taijidjk69.com/'.$val['pic_qn_url'];
                $video_img_is_collect = $video_img_collect -> IsUidCollect($uid,$type,$val['id']);
                $list[$key]['is_collect'] =  empty($video_img_is_collect) ? 0 : 1;
                $list[$key]['collect_id'] =  $video_img_is_collect;
            }
        }
        return $list;
    }


    public function getOneData($id)
    {
        $list = self::where(['status' => 1])
            ->field(['id', 'pic_qn_url'])
            ->find();

        $data = [
            'id' => $list['id'],
            'pic_url' => '\'http://qn.taijidjk69.com/'.$list['pic_qn_url'],
        ];
        return $data;

    }


}