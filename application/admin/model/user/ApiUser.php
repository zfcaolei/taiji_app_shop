<?php

/**

 *

 * @author: xaboy<365615158@qq.com>

 * @day: 2017/11/02

 */

namespace app\admin\model\user;

use app\admin\model\system\SystemAdmin;
use think\Model;
use traits\ModelTrait;
use basic\ModelBasic;
use think\Db;

/**
 * 图文管理 Model
 * Class WechatNews
 * @package app\admin\model\wechat
 */
class ApiUser extends Model {

    protected $table = 'eb_app_user';




    public function CheckToken($token)
    {
        $ApiUserData = self::get(['token'=>$token])->toArray();
        return $ApiUserData;
    }




    public function GetUserList($uid){

        $list = self::where(['id' => $uid])
            ->field(['id', 'username', 'sex', 'phone','image'])
            ->find();

        return $list;
    }


}