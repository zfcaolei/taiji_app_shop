<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/02
 */
namespace app\common\model;



use basic\ModelBasic;
use think\Exception;

/**
 * 验证码
 * Class ArticleCategory
 */
class SmsCode extends ModelBasic
{

    //第一种 设置完整的数据表（包含前缀）
    protected $table = 'eb_sms_code';


    /*
     * 查询获取了多少条验证码
     */
    public function GetCodeNum($phone)
    {

        $start_time = strtotime(date("Y-m-d",time())." 0:0:0");
        $end =  strtotime(date("Y-m-d",time())." 24:00:00");
        $data = self::where('phone',$phone)->where('create_time','>',$start_time)->where('create_time','<',$end)->count();
        return $data;
    }


    /*
     * 校验验证码
     */
    public function CheckPhoneCode($phone)
    {
        $data = [];
        $time = time();
        try {
            //查询ID最大的一条验证码
            $CodeMaxId = self::where('phone', $phone)->max('id');

            if (empty($CodeMaxId)) {
                throw  new Exception('false');
            }

            $CodeData =  self::get(['id'=>$CodeMaxId])->toArray();
            if ($CodeData['uneffect_time']<$time){
                throw  new Exception('验证码失效');
            }

            if (empty($CodeData)){
                throw  new Exception('false');
            }

            $data['save'] = $CodeData['code'];
        }catch (Exception $e){
            $data['msg'] = $e->getMessage();
        }
        return $data;


    }


}