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
 * APP用户表
 * Class ArticleCategory
 */
class AppUser extends ModelBasic
{

    //第一种 设置完整的数据表（包含前缀）
    protected $table = 'eb_app_user';


    public static function getUserInfo($uid)
    {
        $userInfo = self::where('id',$uid)->find();
        if(!$userInfo) exception('读取用户信息失败!');
        return $userInfo->toArray();
    }

    /*
     * 判断app用户是否存在
     */
    public function AppUserExit($phone)
    {
        $data = self::get(['phone'=>$phone]);
        if (empty($data)){
            return false;
        }
        return true;
    }

    //校验token
    public function CheckToken($token)
    {
        $data = [];
        try {
            $ApiUserData = self::get(['token' => $token]);
            $time = time();

            if (empty($ApiUserData)){
                throw  new Exception('请登录');
            }

           // if (!empty($ApiUserData)) {
                //检测token是否过期
//                if ($time > $ApiUserData->time_out) {
//                    throw  new Exception('token过期');
//                }
                $data['save'] = $ApiUserData;
            //}
        }catch (Exception $e){
            $data['msg'] = $e->getMessage();
        }

        return $data;
    }



}