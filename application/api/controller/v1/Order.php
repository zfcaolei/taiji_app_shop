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
use app\admin\model\store\StoreProductAttrValue;
use app\admin\model\system\SystemGroupData;
use app\admin\model\user\ApiUser;
use app\api\controller\Auth;
use app\common\lib\AliSms;
use app\common\lib\Sms;
use app\common\model\AppUser;
use app\routine\model\store\StoreBargainUser;
use app\routine\model\store\StoreCart;
use app\routine\model\store\StoreCouponUser;
use app\routine\model\store\StoreOrder;
use app\routine\model\store\StoreOrderCartInfo;
use app\routine\model\store\StorePink;
use app\routine\model\store\StoreProductAttr;
use app\routine\model\store\StoreProductRelation;
use app\routine\model\store\StoreProductReply;
use app\routine\model\user\User;
use service\HookService;
use service\JsonService;
use service\SystemConfigService;
use service\UtilService;
use think\Controller;
use think\Request;

/*
 * 订单
 */

class Order extends Auth
{


    /**
     * 获取订单列表
     * @param string $type  0待付款  1待发货  2待收货  3待评价  4已完成 5全部
     * @param int $first
     * @param int $limit
     * @param string $search
     * @return \think\response\Json
     */
    public function GetUserOrderList($type = '', $first = 0, $limit = 8, $search = '')
    {
//        StoreOrder::delCombination();//删除拼团未支付订单
        if ($search) {
            $order = StoreOrder::searchUserOrder($this->user->id, $search) ?: [];
            $list = $order == false ? [] : [$order];
        } else {
            $list = StoreOrder::NewgetUserOrderList($this->user->id, $type, $first, $limit);
        }



        foreach ($list as $k => $order) {

            $list[$k] = StoreOrder::tidyOrder($order, true);
           // $list[$k]['unique_data'][] = $order['cartInfo']['unique'];

            foreach ($order['cartInfo'] ?: [] as $key => $product) {
                $list[$k]['unique_data'][] = $product['unique'];
            }


            if ($list[$k]['_status']['_type'] == 3) {
                foreach ($order['cartInfo'] ?: [] as $key => $product) {
                    $list[$k]['cartInfo'][$key]['is_reply'] = StoreProductReply::isReply($product['unique'], 'product');
                }
            }
        }
        return show(1, 'success', $list, 200);

    }


    /**
     * /**
     * 单个商品订单页面   单个商品先加入购物车才能创建订单
     * @param string $key
     * @return \think\response\Json
     */
    public function ConfirmOrder(Request $request)
    {
        $productId = $request->param('productId');
        $cartNum = $request->param('cartNum',1);
        $uniqueId = $request->param('uniqueId','');

        if (!$productId || !is_numeric($productId)) return show(config('code.error'), '参数错误,商品id为空', [], 404);
        $user_id = $this->user->id;
        if (empty($user_id) || !is_numeric($productId)) return show(config('code.error'), '参数错误,用户id为空', [], 404);

        $res = StoreCart::setCart($user_id, $productId, $cartNum, $uniqueId, 'product');
        if (!empty($res->id)) {
           // $data = UtilService::postMore($res->id);
            $cartId = $res->id;
            //svar_dump($cartId);die;
            if (is_string($cartId) || !$cartId) return show(config('code.error'), '请提交购买的商品11111', [], 400);
            $cartGroup = StoreCart::getUserProductCartList($this->user->id, $cartId, 1);
            if (count($cartGroup['invalid']))  return show(config('code.error'), '已失效', $cartGroup['invalid'][0]['productInfo']['store_name'], 400);//return JsonService::fail($cartGroup['invalid'][0]['productInfo']['store_name'] . '已失效!');
            if (!$cartGroup['valid']) return show(config('code.error'), '请提交购买的商品2', [], 400);
            $cartInfo = $cartGroup['valid'];

            $priceGroup = StoreOrder::getOrderPriceGroup($cartInfo);
            $other = [
                'offlinePostage' => SystemConfigService::get('offline_postage'),
                'integralRatio' => SystemConfigService::get('integral_ratio')
            ];
            $usableCoupon = StoreCouponUser::beUsableCoupon($this->user->id, $priceGroup['totalPrice']);
            $cartIdA = explode(',', $cartId);
            if (count($cartIdA) > 1) $seckill_id = 0;
            else {
                $seckillinfo = StoreCart::where('id', $cartId)->find();
                if ((int)$seckillinfo['seckill_id'] > 0) $seckill_id = $seckillinfo['seckill_id'];
                else $seckill_id = 0;
            }
            $delCar = StoreCart::del($cartId);
            if (empty($delCar)){
                    //return JsonService::fail($cartGroup['invalid'][0]['productInfo']['store_name'] . '已失效!');
                return show(config('code.error'), 'false', [], 400);
            }


            //$data['usableCoupon'] = $usableCoupon;
            $data['seckill_id'] = $seckill_id;
            $data['cartInfo'] = $cartInfo;
            $data['priceGroup'] = $priceGroup;
            $data['orderKey'] = StoreOrder::cacheOrderInfo($this->user->id, $cartInfo, $priceGroup, $other);
            $data['offlinePostage'] = $other['offlinePostage'];
           // $data['userInfo'] = User::getUserInfo($this->user->id);
            $data['integralRatio'] = $other['integralRatio'];
            return show(1, 'success', $data, 200);
        }
    }



    /**
     * /**
     * 购物车下单商品订单页面
     * @param string $key
     * @return \think\response\Json
     */
    public function GoodCarConfirmOrder(Request $request)
    {
            $data = UtilService::postMore(['cartId'],$request);
            $cartId = $data['cartId'];

            if (!is_string($cartId) || !$cartId) return show(config('code.error'), '请提交购买的商品1', [], 400);
            $cartGroup = StoreCart::getUserProductCartList($this->user->id, $cartId, 1);
            if (count($cartGroup['invalid']))  return show(config('code.error'), '已失效', $cartGroup['invalid'][0]['productInfo']['store_name'], 400);//return JsonService::fail($cartGroup['invalid'][0]['productInfo']['store_name'] . '已失效!');
            if (!$cartGroup['valid']) return show(config('code.error'), '请提交购买的商品2', [], 400);
            $cartInfo = $cartGroup['valid'];

            $priceGroup = StoreOrder::getOrderPriceGroup($cartInfo);
            $other = [
                'offlinePostage' => SystemConfigService::get('offline_postage'),
                'integralRatio' => SystemConfigService::get('integral_ratio')
            ];
            $usableCoupon = StoreCouponUser::beUsableCoupon($this->user->id, $priceGroup['totalPrice']);
            $cartIdA = explode(',', $cartId);
            if (count($cartIdA) > 1) $seckill_id = 0;
            else {
                $seckillinfo = StoreCart::where('id', $cartId)->find();
                if ((int)$seckillinfo['seckill_id'] > 0) $seckill_id = $seckillinfo['seckill_id'];
                else $seckill_id = 0;
            }

            $data['seckill_id'] = $seckill_id;
            $data['cartInfo'] = $cartInfo;
            $data['priceGroup'] = $priceGroup;
            $data['orderKey'] = StoreOrder::cacheOrderInfo($this->user->id, $cartInfo, $priceGroup, $other);
            $data['offlinePostage'] = $other['offlinePostage'];
            $data['integralRatio'] = $other['integralRatio'];
            return show(1, 'success', $data, 200);

    }





    /*
     * useIntegral  使用积分
     */
    public function createorderpay($key = '')
    {

        if(!$key) return JsonService::fail('参数错误!');
        if(StoreOrder::be(['order_id|unique'=>$key,'uid'=>$this->user->id,'is_del'=>0]))
                return show(1, '订单已生成',['orderId'=>$key,'key'=>$key], 200);

        list($addressId,$couponId,$payType,$useIntegral,$mark,$combinationId,$pinkId,$seckill_id,$formId,$bargainId) = UtilService::postMore([
            'addressId','couponId','payType','useIntegral','mark',['combinationId',0],['pinkId',0],['seckill_id',0],['formId',''],['bargainId','']
        ],Request::instance(),true);
        $payType = strtolower($payType);
        if($bargainId) StoreBargainUser::setBargainUserStatus($bargainId,$this->user->id);//修改砍价状态
        if($pinkId) if(StorePink::getIsPinkUid($pinkId,$this->user->id)) return JsonService::status('ORDER_EXIST','订单生成失败，你已经在该团内不能再参加了',['orderId'=>StoreOrder::getStoreIdPink($pinkId,$this->userInfo['uid'])]);
        if($pinkId) if(StoreOrder::getIsOrderPink($pinkId,$this->user->id)) return JsonService::status('ORDER_EXIST','订单生成失败，你已经参加该团了，请先支付订单',['orderId'=>StoreOrder::getStoreIdPink($pinkId,$this->userInfo['uid'])]);
        $order = StoreOrder::cacheKeyCreateOrder($this->user->id,$key,$addressId,$payType,$useIntegral,$couponId,$mark,$combinationId,$pinkId,$seckill_id,$bargainId);




        $orderId = $order['order_id'];
        $info = compact('orderId','key');
        if($orderId){
            if($payType == 'weixin'){
                $orderInfo = StoreOrder::where('order_id',$orderId)->find();
                if(!$orderInfo || !isset($orderInfo['paid'])) exception('支付订单不存在!');
                if($orderInfo['paid']) exception('支付已支付!');
                //如果支付金额为0
                if(bcsub((float)$orderInfo['pay_price'],0,2) <= 0){
                    //创建订单jspay支付
                    if(StoreOrder::jsPayPrice($orderId,$this->user->id,$formId))
                        return show(1, '微信支付成功',$info, 200);
                    else
                        return show(0, StoreOrder::getErrorInfo(),$info, 400);
                }else{
                    try{
                        $jsConfig = StoreOrder::jsPay($orderId);//创建订单jspay
                    }catch (\Exception $e){
                      //  return JsonService::status('pay_error',$e->getMessage(),$info);
                        return show(0,$e->getMessage(),$info, 400);
                    }
                    $info['jsConfig'] = $jsConfig;
                    return show(0,'订单创建成功',$info, 200);
                   // return JsonService::status('wechat_pay','订单创建成功',$info);
                }
            }else if($payType == 'yue'){
                if(StoreOrder::yuePay($orderId,$this->user->id,$formId))
                    //return JsonService::status('success','余额支付成功',$info);
                    return show(1,'余额支付成功',$info, 200);
                else
                   // return JsonService::status('pay_error',StoreOrder::getErrorInfo());
                    return show(0,StoreOrder::getErrorInfo(),[], 400);
            }else if($payType == 'offline'){
//                RoutineTemplate::sendOrderSuccess($formId,$orderId);//发送模板消息
                //return JsonService::status('success','订单创建成功',$info);
                return show(1,'订单创建成功',$info, 200);
            }
        }else{
           // return JsonService::fail(StoreOrder::getErrorInfo('订单生成失败!'));
            return show(1,'订单生成失败11',[], 400);
        }
    }










    /**
     * 订单详情页
     * @param string $order_id
     * @return \think\response\Json
     */
    public function GetOrder($uni = ''){
        if($uni == '')  return show(1,'参数错误',[], 400); //return JsonService::fail('参数错误');
        $order = StoreOrder::getUserOrderDetail($this->user->id,$uni);
        $order = $order->toArray();
        $order['add_time'] = date('Y-m-d H:i:s',$order['add_time']);
        $order['favourable_price'] = bcadd($order['deduction_price'],$order['coupon_price'],2);
        if(!$order)  return show(config('code.error'),'订单不存在',[], 400);//return JsonService::fail('订单不存在');
        return show(1,'success',StoreOrder::tidyOrder($order,true), 400);
        //return JsonService::successful(StoreOrder::tidyOrder($order,true));
    }



    /**
     * 用户确认收货
     * @param string $uni
     * @return \think\response\Json
     */
    public function UserTakeOrder($uni = '')
    {
        if(!$uni)  return show(config('code.error'),'参数错误',[], 400);

        $res = StoreOrder::takeOrder($uni,$this->user->id);
        if($res)
            //return JsonService::successful();
            return show(1,'success',[], 400);
        else
            //return JsonService::fail(StoreOrder::getErrorInfo());
            return show(1,StoreOrder::getErrorInfo(),[], 400);
    }



    /**
     * 评价订单
     * @param string $unique
     * @return \think\response\Json
     */
    public function UserCommentProduct($unique = '')
    {
        if(!$unique) return show(config('code.error'),'参数错误',[], 400);//return JsonService::fail('参数错误!');
        $cartInfo = StoreOrderCartInfo::where('unique',$unique)->find();
        $uid = $this->user->id;
        if(!$cartInfo || $uid != $cartInfo['cart_info']['uid'])  return show(config('code.error'),'评价产品不存在',[], 400);//return JsonService::fail('评价产品不存在!');
        if(StoreProductReply::be(['oid'=>$cartInfo['oid'],'unique'=>$unique]))
            //return JsonService::fail('该产品已评价!');
            return show(config('code.error'),'该产品已评价',[], 400);
        $group = UtilService::postMore([
            ['comment',''],['pics',[]],['product_score',5],['service_score',5]
        ],Request::instance());
     

        $group['comment'] = htmlspecialchars(trim($group['comment']));
        if($group['product_score'] < 1)    return show(config('code.error'),'请为产品评分',[], 400);//return JsonService::fail('请为产品评分');
        else if($group['service_score'] < 1)  return show(config('code.error'),'请为商家服务评分',[], 400);//return JsonService::fail('请为商家服务评分');
        if($cartInfo['cart_info']['combination_id']) $productId = $cartInfo['cart_info']['product_id'];
        else if($cartInfo['cart_info']['seckill_id']) $productId = $cartInfo['cart_info']['product_id'];
        else if($cartInfo['cart_info']['bargain_id']) $productId = $cartInfo['cart_info']['product_id'];
        else $productId = $cartInfo['product_id'];
        $group = array_merge($group,[
            'uid'=>$uid,
            'oid'=>$cartInfo['oid'],
            'unique'=>$unique,
            'product_id'=>$productId,
            'reply_type'=>'product'
        ]);
        StoreProductReply::beginTrans();
        $res = StoreProductReply::reply($group,'product');
        if(!$res) {
            StoreProductReply::rollbackTrans();
            //return JsonService::fail('评价失败!');
            return show(config('code.error'),'评价失败',[], 400);
        }
        try{
//            HookService::listen('store_product_order_reply',$group,$cartInfo,false,StoreProductBehavior::class);
            StoreOrder::checkOrderOver($cartInfo['oid']);
        }catch (\Exception $e){
            StoreProductReply::rollbackTrans();
           // return JsonService::fail($e->getMessage());
            return show(config('code.error'),$e->getMessage(),[], 400);

        }
        StoreProductReply::commitTrans();
       // return JsonService::successful();
        return show(config('code.error'),'success',[], 200);
    }

    /**
     * 申请退款
     * @param string $uni
     * @param string $text
     * @return \think\response\Json
     */
    public function ApplyOrderRefund(Request $request,$uni = '')
    {
        $data = UtilService::postMore([
            ['text',''],
            ['refund_reason_wap_img',''],
            ['refund_reason_wap_explain',''],
        ],$request);
        if($data['refund_reason_wap_img']) $data['refund_reason_wap_img'] = explode(',',$data['refund_reason_wap_img']);
        if(!$uni || $data['text'] == '') return JsonService::fail('参数错误!');
        $res = StoreOrder::orderApplyRefund($uni,$this->user->id,$data['text'],$data['refund_reason_wap_explain'],$data['refund_reason_wap_img']);

        if($res)
          return show(1,'success',[], 200);
        else
         return show(0,StoreOrder::getErrorInfo(),[], 400);
       // var_dump(StoreOrder::getErrorInfo());
    }

}

