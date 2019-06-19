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
use app\admin\model\user\User;
use app\api\controller\Common;
use app\common\lib\AliSms;
use app\common\lib\IAuth;
use app\common\lib\Sms;
use app\common\model\AppUser;
use think\Controller;
//use app\common\lib\exception\ApiException;
//use app\common\lib\Aes;
//use ali\top\TopClient;
//use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
//use app\common\lib\Alidayu;

class Login extends Common {


    /*
     * APP登录操作
     */
    public function index()
   {
        //提交方式验证
        if (!request()->isPost()){
            return show(config('code.error'),'您没有权限','',403);
        }

        $param = input('param.');
        //手机号码验证
        if (empty($param['phone'])){
            return show(config('code.error'),'手机不合法','',404);
        }
        //验证码验证
       if (empty($param['code'])){
           return show(config('code.error'),'手机短信验证码不合法','',404);
       }

       //比对数据库的验证码和接受过来的验证码是否一致
        $SmsCode = new \app\common\model\SmsCode();
        $code = $SmsCode->CheckPhoneCode($param['phone']);
        if (!empty($code['msg'])){
            return show(config('code.error'),$code['msg'],'[]',404);
        }


        //验证码校验对比
        if ((int)$param['code'] !== $code['save']) {
            return show(config('code.error'),'验证码错误','[]',404);
        }


            $AppUserModel = new AppUser();
            //判断是否登录过
            if ($AppUserModel->AppUserExit($param['phone']) == false) {

                //统一参数
                $data = [
                    'token' => IAuth::setAppLoginToken($param['phone']),  //加密token
                    'username' => $param['phone'],                        //用户名称随机
                    'phone' => $param['phone'],                           //用户名称
                    'time_out' => time()+config('token.token_end_time'), //token失效时间
                    'last_time' =>time(),                                 //最后登录时间
                    'add_time'  => time(),                                //第一次登录时间
                ];


                   //把user表和appuser表数据统一
                    $UserModel = new User();
                    $UserModel -> nickname = $data['phone'];
                    $UserModel -> account = $data['phone'];
                    $UserModel -> phone = $data['phone'];
                    $UserModel -> pwd = '';
                    $UserModel -> avatar = '';
                    $UserModel -> add_ip = '';
                    $UserModel -> add_time = $data['add_time'];
                    if(!$UserModel -> save()){
                        return show(config('code.error'),'系统错误','',404);
                    }


                //同步app_user表
                $data['user_id'] = $UserModel->uid;
                $AppUserModel = new AppUser();
                $res = $AppUserModel->save($data);



            }else{

                //用户存在更新token和token失效时间
                $AppUserModelData = AppUser::get(['phone'=>$param['phone']]);
                $data = [
                    'token' => IAuth::setAppLoginToken($param['phone']),  //加密token
                    'time_out' => time()+config('token.token_end_time'), //token失效时间
                    'last_time' =>time(),                                 //最后登录时间
                ];
                $res = $AppUserModelData->save($data);
            }

            if (!empty($res)){
                return show(1,'登录成功',$data['token'],200);
            }



    }







}