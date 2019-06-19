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
use app\routine\model\store\StoreCart;
use service\HookService;
use service\JsonService;
use think\Controller;
use think\Request;

/*
 * 购物车
 */

class Goodcar extends Auth {


    /*
     * 加入购物车
     */
    public function JoinCar($productId = '',$cartNum = 1,$uniqueId = '')
    {
        if (!$productId || !is_numeric($productId)) return show(config('code.error'), '参数错误,商品id为空', [], 404);
        $user_id = $this->user->id;
        if (empty($user_id) || !is_numeric($productId)) return show(config('code.error'), '参数错误,用户id为空', [], 404);

        $res = StoreCart::setCart($user_id, $productId, $cartNum, $uniqueId, 'product');
        if (!$res) return show(config('code.error'), StoreCart::getErrorInfo(), [], 404);
        else {
            return show(1, 'success', ['cartId' => $res->id], 200);
        }
    }


    public function GetCartList(){
       // return JsonService::successful(StoreCart::getUserProductCartList($this->userInfo['uid']));
        return show(1, 'success', StoreCart::getUserProductCartList($this->user->id)['valid'], 200);
    }



//        /**
//         * 获取购物车数量
//         * @return \think\response\Json
//         */
        public function GetCartNum()
        {
            return show(1, 'success',StoreCart::getUserCartNum($this->user->id,'product'), 200);
         }

        /**
         * 修改购物车产品数量
         * @param string $cartId
         * @param string $cartNum
         * @return \think\response\Json
         */
        public function ChangeCartNum($cartId = '',$cartNum = '')
        {
            if(!$cartId || !$cartNum || !is_numeric($cartId) || !is_numeric($cartNum)) return  show(config('code.error'), '参数错误', [], 300);
            StoreCart::changeUserCartNum($cartId,$cartNum,$this->user->id);
            return show(1, 'success',[], 200);
       }

        /**
         * 删除购物车产品
         * @param string $ids
         * @return \think\response\Json
         */
        public function RemoveCart($cartId=''){
        if(!$cartId) return show(config('code.error'), '购物车id不能为空', [], 300);
        if (!is_array(json_decode($cartId))) return show(config('code.error'), '参数格式错误', [], 300);
            $cartId = implode(',',json_decode($cartId));
        $res =  StoreCart::removeUserCart($this->user->id,$cartId);
        if(empty($res)){
            return show(1, '删除失败',[], 300);
        }
            return show(1, 'success',[], 200);
        }



}

