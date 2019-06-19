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
use app\api\controller\Common;
use app\common\lib\AliSms;
use app\common\lib\Sms;
use think\Controller;
use think\Exception;

//use app\common\lib\exception\ApiException;
//use app\common\lib\Aes;
//use ali\top\TopClient;
//use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
//use app\common\lib\Alidayu;

class Smscode extends Common {

    /*
     * 发送验证码
     */
    public function Sendcode()
    {
        $msg = [];
        if (!request()->isPost()){
            return show(config('code.error'),'您没有权限','',403);
        }
        $param = input('param.');

        //手机号码验证
        if (empty($param['phone'])){
            return show(config('code.error'),'手机号码为空','',404);
        }
            $sms = new SendSms();
            $SmsCode = new \app\common\model\SmsCode();

            //每天信息不能超过10条限制
            $PhoneCodeCount = $SmsCode->GetCodeNum($param['phone']);
            if ($PhoneCodeCount>=10) {
                return show(config('code.error'), '超过验证码限制数量', '[]', 400);
            }

            $code = rand(1000,9999);
            $templateParam = array("code"=>$code);
            $res = $sms->send($param['phone'],$templateParam);

            if ($res['Code'] !== 'OK'){
                return show(config('code.error'),'验证码发送失败','[]',400);
            }

            //验证码操作加入数据库
        try{
            $data = [
                'phone' => $param['phone'],
                'code' => $code,
                'create_time' => time(),
                'uneffect_time' => time()+\think\Config::get('sms.sms_out_time'),
            ];
            $res = $SmsCode->save($data);
            if (empty($res)){
                throw  new Exception('系统错误');
            }
            return show(1,'发送成功','[]',200);
        }catch (\Exception $e){
            return show(config('code.error'),$e->getMessage(),'[]',400);
        }

    }



}