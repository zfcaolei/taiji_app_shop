<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller;

use Ali\Core\Config;
use alisms\SendSms;
use app\admin\model\user\ApiUser;
use app\common\lib\AliSms;
use app\common\lib\exception\ApiException;
use app\common\lib\Sms;
use app\common\model\AppUser;
use think\Controller;
use think\Exception;
use think\Request;


/*
 * 权限控制器，验证token是否通过
 */
class Auth extends Common {

    public $user = [];

    public function _initialize() {
        $this->CheckToken();
    }


    /*
     * 验证token
     */
    public function CheckToken()
    {
        //todo 首先客户端要解密token再验证，这一步最后开发

        //接受参数token并且验证
        $request = Request::instance();
        $token = $request->param('token');

        if (empty($token)){
         //   return show(config('code.error'),'您没有权限,token参数为空','[]',404);
            throw new ApiException('您没有权限,token参数为空', 400);
        }

        //从数据库查找token
        $ApiUserModel = new AppUser();
        $res = $ApiUserModel -> CheckToken($token);

        if (!empty($res['msg']) && $res['msg'] == '请登录'){
         //   return show(3,'token错误','[]',404);
            throw new ApiException('token错误', 400);
        }

        if (!empty($res['msg']) && $res['msg'] == 'token过期'){
            //  return show(3,'token过期,请重新登录','[]',404);
             throw new ApiException('token过期,请重新登录', 400,3);
        }

        if (!empty($res['save'])){
            $this->user = $res['save'];
        }

    }





}