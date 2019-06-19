<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\test;

use Ali\Core\Config;
use alisms\SendSms;
use app\admin\model\user\ApiUser;
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

class Test extends Controller {


        public function index()
        {
//            $sms = new SendSms();
//            $mobile = '15111178786';
//            //模板参数，自定义了随机数，你可以在这里保存在缓存或者cookie等设置有效期以便逻辑发送后用户使用后的逻辑处理
//            $code = mt_rand();
//            $templateParam = array("code"=>$code);
//            $m = $sms->send($mobile,$templateParam);
//            //类中有说明，默认返回的数组格式，如果需要json，在自行修改类，或者在这里将$m转换后在输出
//            dump($m);

//            $model = new \app\common\model\SmsCode();
//
//            $appUser = new AppUser();
//
//            $data = AppUser::get(['id'=>5]);
//            $s = [
//                'sex' =>1,
//            ];
//            $res = $data->save($s);
//            var_dump($res);
           // var_dump($appUser->AppUserExit(15111178786));

//            var_dump(\think\Config::get('sms.sms_out_time'));

//            $request = Request::instance();
//            var_dump($request->param());

            $Api  = new AppUser();

            var_dump(222);


        }





//   public function sendsms()
//  {
////            $mobile = $phone;
////            //$code = 1111;
////            $code = mt_rand(10000, 99999);
////            $result = sendMsg($mobile, $code);
////            //$result['Code'] = 'OK';
////            if ($result['Code'] == 'OK') {
////                //存到缓存当中,并且返回json数据给前端
////                cache('tel' . $mobile, $code, 39);
////                return json(['success' => 'ok', 'tel' => $mobile]);
////            }
//       }

//       public function sendsms()
//       {
//           $mobile = 15111178786;
//           $code = mt_rand(10000, 99999);
//
//           $model = new Sms();
//           $result = $model->sendMsg($mobile, $code);
//           var_dump($result);
//
//       }


    public function update($id = 0) {
        //echo $id;exit;
        halt(input('put.'));
        //return $id;
        //id   data
    }

    /**
     * post 新增
     * @return mixed
     */
    public function save()
    {
//        $data = input('post.');
//
//        // 获取到提交数据 插入库，
//        // 给客户端APP  =》 接口数据
//        return show(1, 'OK', (new Aes())->encrypt(json_encode(input('post.'))), 201);
    }

    /**
     * 发送短信测试场景
     */
//    public function sendSms() {
//        $c = new TopClient;
//        $c->appkey = "LTAIcf5f9dcbeyww";
//        $c->secretKey = "xozr4zUEjEg0W1D8wpddCKel3eZb8r ";
//        $req = new AlibabaAliqinFcSmsNumSendRequest;
//        $req->setExtend("123456");
//        $req->setSmsType("normal");
//        $req->setSmsFreeSignName("singwa娱乐app");
//        $req->setSmsParam("{\"number\":\"4567\"}");
//        $req->setRecNum("18618158941");
//        $req->setSmsTemplateCode("SMS_75915048");
//        $resp = $c->execute($req);
//        halt($resp);
//    }
//
//    public function testsend() {
//        Alidayu::getInstance()->setSmsIdentify('18618158941');
//    }

    ///  APP登录和web
    // web phpsessionid  , app -> token(唯一性) ，在登录状态下 所有的请求必须带token, token-》失效时间


}