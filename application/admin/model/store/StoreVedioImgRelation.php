<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/02
 */
namespace app\admin\model\store;



use app\admin\model\vedio\Vedio;
use basic\ModelBasic;
use think\Exception;

/**
 * 视频图片收藏表
 * Class ArticleCategory
 */
class StoreVedioImgRelation extends ModelBasic
{


    //第一种 设置完整的数据表（包含前缀）
    protected $table = 'eb_store_vedio_img_relation';


    /*
     * 收藏视频及图片
     * 1=>视频 2=>图片
     */
    public function Add($id,$type,$uid)
    {
        $data = [];
        try {
            $model = new self();
            $result = [
                'vedio_img_id' => $id,
                'type' => $type,
                'add_time' => time(),
                'uid' => $uid,
            ];

            if (!$model->save($result)){
                throw  new Exception('添加失败');
            }
            $data['save'] = $model->id;
        }catch (Exception $e){
            $data['msg'] = $e->getMessage();
        }
        return $data;
    }


//    public function vedio()
//    {5rt
//        return $this->hasOne('Vedio');
//    }

    function vedio()
    {
        return $this->hasOne('\app\admin\model\vedio\Vedio','id','vedio_img_id');
    }


    function pic()
    {
        return $this->hasOne('\app\admin\model\vedio\Pic','id','vedio_img_id');
    }


    /*
     * 获取收藏视频和图片的列表
     */
    public function GetList($uid,$type=1)
    {
        $res = [];
        $table = $type== 1 ? 'vedio' : 'pic';
        $data = self::where(['uid'=>$uid])->where(['type'=>$type])->with($table)->select();
        if (!empty($data)){
            foreach ($data as $key => $v){
                if ($type == 1) {
                    $res[$key] = [
                        'collect_id' => $v['id'],
                        'id' => $v['vedio']['id'],
                        'name' => $v['vedio']['vedio_name'],
                        'img' => $v['vedio']['vedio_img'],
                        'url' => config('qn.url').'/'.$v['vedio']['vedio_url']
                    ];
                }else{
                    $res[$key] = [
                        'collect_id' => $v['id'],
                        'id' => $v['pic']['id'],
                        'name' => $v['pic']['pic_name'],
                        'img' => config('qn.url').'/'.$v['pic']['pic_qn_url'],
                        'url' => config('qn.url').'/'.$v['pic']['pic_qn_url']
                    ];
                }
            }
        }
        return $res;

    }


    /*
     * 批量删除
     */
    public function OptionDel($uid,$optionId,$type){
        $data = [];
        try{
            $res = self::where('id','in',$optionId)->where(['type'=>$type])->delete();
            if (empty($res)){
                throw new Exception('删除失败');
            }
            $data['save'] = true;

        }catch (Exception $e){
            $data['msg'] = $e->getMessage();
        }

        return $data;
    }


    public function IsUidCollect($uid,$type,$id)
    {
        $data = self::where(['uid'=>$uid,'type'=>$type,'vedio_img_id'=>$id])->find();
        if (empty($data)){
            return 0;
        }else {
            return $data['id'];
        }
    }



}