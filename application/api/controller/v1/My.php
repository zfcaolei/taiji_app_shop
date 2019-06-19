<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;

use Ali\Core\Config;
use alisms\SendSms;
use app\admin\model\store\StoreCategory;
use app\admin\model\store\StoreProduct;
use app\admin\model\system\SystemGroupData;
use app\admin\model\user\ApiUser;
use app\api\controller\Auth;
use app\common\lib\AliSms;
use app\common\lib\Sms;
use app\common\model\AppUser;
use think\Controller;
use think\Request;

//use app\common\lib\exception\ApiException;
//use app\common\lib\Aes;
//use ali\top\TopClient;
//use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
//use app\common\lib\Alidayu;

class My extends Auth {


    /*
     * 我的个人信息
     */
    public function Myinfo()
    {
        $uid = $this->user->id;
        return $uid;
    }



}

