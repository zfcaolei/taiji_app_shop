<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;


use app\api\controller\Auth;
use app\routine\model\user\UserAddress;
use service\JsonService;
use service\UtilService;
use think\Request;


/*
 * 用户地址
 */

class  Address extends Auth {

    /**
     * 新增修改收货地址
     * @return \think\response\Json
     */
        public function EditUserAddress()
    {
        $request = Request::instance();
        if(!$request->isPost())   return show(config('code.error'), '参数错误',[], 200);
        $addressInfo = UtilService::postMore([
            ['address',[]],
            ['is_default',false],
            ['real_name',''],
            ['post_code',''],
            ['phone',''],
            ['detail',''],
            ['id',0]
        ],$request);
        if (empty($addressInfo['address']['province']) || empty($addressInfo['address']['province']) || empty($addressInfo['address']['province']) || empty($addressInfo['phone']) ){
            return  show(config('code.error'), '参数错误1',[], 200);
        }

        $addressInfo['province'] = $addressInfo['address']['province'];
        $addressInfo['city'] = $addressInfo['address']['city'];
        $addressInfo['district'] = $addressInfo['address']['district'];
        $addressInfo['is_default'] = $addressInfo['is_default'] == true ? 1 : 0;
        $addressInfo['uid'] = $this->user->id;
        unset($addressInfo['address']);

        if($addressInfo['id'] && UserAddress::be(['id'=>$addressInfo['id'],'uid'=>$this->user->id,'is_del'=>0])){
            $id = $addressInfo['id'];
            unset($addressInfo['id']);
            if(UserAddress::edit($addressInfo,$id,'id')){
                if($addressInfo['is_default'])
                    UserAddress::setDefaultAddress($id,$this->user->id);
              //  return JsonService::successful();
                return show(1, 'success',[], 200);
            }else
               // return JsonService::fail('编辑收货地址失败!');
            return show(config('code.error'), '编辑收货地址失败',[], 405);
        }else{
            if($address = UserAddress::set($addressInfo)){
                if($addressInfo['is_default'])
                    UserAddress::setDefaultAddress($address->id,$this->user->id);
                return show(1, 'success',[], 200);
            }else
                return show(config('code.error'), 'false',[], 405);
        }
    }

    /**
     * 获取默认地址
     * @return \think\response\Json
     */
    public function UserDefaultAddress()
    {
        $defaultAddress = UserAddress::getUserDefaultAddress($this->user->id,'id,real_name,phone,province,city,district,detail,is_default');
        if($defaultAddress) return   show(1, 'success',$defaultAddress, 200);
        else    return show(config('code.error'), '获取地址失败,无数据',[], 405);
    }


    /**
     * 设置为默认地址
     * @param string $addressId
     * @return \think\response\Json
     */
    public function SetUserDefaultAddress($addressId = '')
    {
        if(!$addressId || !is_numeric($addressId))  return show(config('code.error'), '参数错误',[], 405);
        if(!UserAddress::be(['is_del'=>0,'id'=>$addressId,'uid'=>$this->user->id]))
            return show(config('code.error'), '地址不存在',[], 405);
        $res = UserAddress::setDefaultAddress($addressId,$this->user->id);
        if(!$res)
            return show(config('code.error'), '参数错误',[], 405);
        else
            return show(1, 'success',[], 200);
    }




    /**
     * 删除地址
     * @param string $addressId
     * @return \think\response\Json
     */
    public function RemoveUserAddress($addressId = '')
    {
        if(!$addressId || !is_numeric($addressId)) return show(config('code.error'), '参数错误',[], 405);
        if(!UserAddress::be(['is_del'=>0,'id'=>$addressId,'uid'=>$this->user->id]))
            return show(config('code.error'), '地址不存在',[], 405);
        if(UserAddress::edit(['is_del'=>'1'],$addressId,'id'))
            return show(1, 'success',[], 200);
        else
          //  return JsonService::fail('删除地址失败!');
        return show(config('code.error'),'删除地址失败', 'success',[], 200);

    }


    /**
     * 获取用户所有地址
     * @return \think\response\Json
     */
    public function UserAddressList()
    {
        $list = UserAddress::getUserValidAddressList($this->user->id,'id,real_name,phone,province,city,district,detail,is_default');
        return show(1,'success',$list, 200);
    }



}

