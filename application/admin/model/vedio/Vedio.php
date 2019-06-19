<?php

/**

 *

 * @author: xaboy<365615158@qq.com>

 * @day: 2017/11/02

 */

namespace app\admin\model\vedio;

use app\admin\model\store\StoreVedioImgRelation;
use app\admin\model\system\SystemAdmin;
use app\common\lib\Fun;
use think\Model;
use traits\ModelTrait;
use basic\ModelBasic;
use think\Db;


class Vedio extends Model {


    use ModelTrait;
    protected $table = 'eb_vedio';




    /**
     * 获取系统分页数据   分类
     * @param array $where
     * @return array
     */
    public static function systemPage($where = array()){
        $model = new self;
        if($where['vedio_name'] !== '') $model = $model->where('vedio_name','LIKE',"%$where[vedio_name]%");
        if($where['status'] !== '') $model = $model->where('status',$where['status']);
        $model = $model->where('is_del',0);

        return self::page($model,[],[],10);
    }


    public function GetLists($uid,$type){
        $list = self::where(['status' => 1])
            ->field(['id', 'vedio_name', 'vedio_img', 'vedio_url', 'vedio_time'])
            ->paginate(10);

        if (!empty($list)){
            $video_img_collect = new StoreVedioImgRelation();
            foreach ($list as $k => $v){
                $list[$k]['vedio_url'] = config('qn.url').'/'.$v['vedio_url'];
                $video_img_is_collect = $video_img_collect -> IsUidCollect($uid,$type,$v['id']);
                $list[$k]['is_collect'] =  empty($video_img_is_collect) ? 0 : 1;
                $list[$k]['collect_id'] = $video_img_is_collect;
            }
        }

        return $list;
    }




    public function getOneData($id)
    {
        $list = self::where(['status' => 1])
            ->field(['id', 'vedio_name', 'vedio_url', 'vedio_time'])
            ->find();

        return $list;

    }


    /*
     * 获取视频时长
     */
    public static function GetVedioTime($url)
    {
        $vedio_time = 0;
        $url = config('qn.url').'/'.$url.'?'.'avinfo';
        $fun = new Fun();
        $data = \Qiniu\json_decode($fun->http_request($url));
        if (!empty($data)) {
            $vedio_time = round($data->streams[0]->duration);
        }
        return $vedio_time;
    }






}