<?php
namespace app\api\controller\v1;


use app\admin\model\user\ApiUser;
use app\api\controller\Auth;
use app\common\model\AppUser;
use service\JsonService;
use service\UploadService;
use service\UtilService;
use think\Exception;
use think\Request;

class Setting extends Auth{

    /*
     * 设置列表页
     */
    public function Lists()
    {
        $uid = $this->user->id;
        if (empty($uid)) return show(config('code.error'), '参数错误', [], 400);
        $AppUserModel = new ApiUser();
        $data = $AppUserModel->GetUserList($uid);
        return show(1, 'success', $data, 200);
    }


    public function upload(Request $request)
    {

        if (empty($_FILES['filename'])){
            return show(0, 'false', '上传图片为空', 400);
        }

        $res = UploadService::image('filename','store/comment');
        if($res->status == 200)
            return  show(1, 'success', ['name'=>$res->fileInfo->getSaveName(),'url'=>[UploadService::pathToUrl($res->dir)]], 200);
        else
            return show(0, 'false', $res->error, 400);

    }

    /*
     * 多图上传
     */
    public function uploadMore(Request $request)
    {
        $files = request()->file('file');
        $path = ROOT_PATH . 'public' . DS . 'uploads/store/comment';
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下

            $info = $file->rule('uniqid')->validate(['size' => 2 * 1024 * 1024, 'ext' =>'jpg,png,gif'])->move($path);
//            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/store/comment');
            if(!isset($_FILES['file']))  return show(0, 'false', '上传图片为空', 400);




            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $data[] = $info->getFilename();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        var_dump($data);
    }





    /*
     * 修改昵称
     */
    public function Modname(Request $request)
    {
        if (!$request->isPost()){
            return show(config('code.error'), '参数错误', [], 400);
        }
        $uid = $this->user->id;
        if (empty($uid)){
            return show(config('code.error'), '参数错误', [], 400);
        }
        $username = $request->post('username');
        if (empty($username)){
            return show(config('code.error'), '参数错误', [], 400);
        }
        $AppUserModel =  AppUser::get($uid);
        $AppUserModel -> username = $username;
        if (!$AppUserModel -> save()){
            return show(config('code.error'), '修改失败', [], 400);
        }
        return show(1, 'success', [], 200);
    }



    /*
     * 修改手机号码
     */
    public function ModTel(Request $request)
    {
        if (!$request->isPost()){
            return show(config('code.error'), '参数错误', [], 404);
        }
        $uid = $this->user->id;
        if (empty($uid)){
            return show(config('code.error'),'参数错误','[]',404);
        }

        $user_code = $request->post('code');
        $phone = $request->post('phone');
        if (empty($code) && empty($phone)){
            return show(config('code.error'), '参数错误', [], 404);
        }

        //验证码校验对比
        $SmsCode = new  \app\common\model\SmsCode();
        $code = $SmsCode->CheckPhoneCode($phone);
        if (!empty($code['msg'])){
            return show(config('code.error'),$code['msg'],'[]',404);
        }

        if ((int)$user_code !== $code['save']) {
            return show(config('code.error'),'验证码错误','[]',404);
        }

        //修改数据
        $AppUserModel =  AppUser::get($uid);
        $AppUserModel -> phone = $phone;
        if (!$AppUserModel -> save()){
            return show(config('code.error'),'修改失败','[]',404);
        }

        return show(1,'success','[]',200);
    }


}