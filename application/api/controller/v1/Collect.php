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
use app\common\model\StoreVedioImgRelation;
use app\routine\model\store\StoreCart;
use app\routine\model\store\StoreProductRelation;
use service\HookService;
use service\JsonService;
use think\Controller;
use think\Exception;
use think\Request;

/*
 * 商品收藏
 */

class Collect extends Auth {


    /**
     * 添加收藏
     * @param $productId
     * @param string $category
     * @return \think\response\Json
     */
    public function Collectproduct($productId,$category = 'product')
    {
        if (!$productId || !is_numeric($productId))  return show(config('code.error'), '参数错误', [], 400);
        $res = StoreProductRelation::productRelation($productId,$this->user->id,'collect',$category);
        if(!$res) return show(1, StoreProductRelation::getErrorInfo(), [], 400);
        else return show(1, 'success', 'true', 200);
    }




    /**
     * 取消收藏
     * @param $productId
     * @param string $category
     * @return \think\response\Json
     */
    public function UncollectProduct($productId,$category = 'product'){
        if(!$productId) return show(config('code.error'), '参数错误', [], 400);
        if (!is_array(json_decode($productId))) return show(config('code.error'), '参数格式错误', [], 400);
        $res = StoreProductRelation::unProductRelation(json_decode($productId),$this->user->id,'collect',$category);
        if(!$res) return show(1, StoreProductRelation::getErrorInfo(), [], 400);
        else return show(1, 'success', [], 200);
    }






    /**
     * 获取收藏产品
     * @param int $first
     * @param int $limit
     * @return \think\response\Json
     */
    public function Getusercollectproduct($first = 0,$limit = 8)
    {
        $list = StoreProductRelation::where('A.uid',$this->user->id)
            ->field('B.id pid,B.store_name,B.price,B.ot_price,B.sales,B.image,B.is_del,B.is_show')->alias('A')
            ->where('A.type','collect')->where('A.category','product')
            ->order('A.add_time DESC')->join('__STORE_PRODUCT__ B','A.product_id = B.id')
            ->limit($first,$limit)->select()->toArray();
        foreach ($list as $k=>$product){
            if($product['pid']){
                $list[$k]['is_fail'] = $product['is_del'] && $product['is_show'];
            }else{
                unset($list[$k]);
            }
        }
        return show(1, 'success',$list, 200);
    }


    /*
     *添加视频图片收藏
     */
    public function VedioImgCollect(Request $request)
    {
        $id = $request->post('id');
        $type = $request->post('type');
        $uid = $this->user->id;

        if (empty($id) || empty($type) || !is_numeric($type))  return show(config('code.error'), '参数错误', [], 400);
        $model = new \app\admin\model\store\StoreVedioImgRelation();
        $data = $model->Add($id,$type,$uid);
        $res['id'] = $data['save'];
        if (!empty($data['msg'])){
            return show(config('code.error'), '收藏失败', [], 400);
        }
        return show(1, 'success', $res, 200);
    }


    /*
     * 图片视频收藏列表
     */
    public function VedioImgCollectList(Request $request)
    {
        $uid = $this->user->id;
        $type = $request->param('type');  //1=>视频  2=>图片
        if (empty($type) && !is_numeric($type)){
            return show(config('code.error'), '参数错误', [], 400);
        }
        $model = new \app\admin\model\store\StoreVedioImgRelation();
        $data = $model->GetList($uid,$type);

        return show(1, 'success',$data, 200);

    }



    /*
     * 图片视频收藏批量删除
     */
    public function VedioImgCollectDel(Request $request)
    {
        $uid = $this->user->id;
        $optionId = json_decode($request->post('optionId'));
        $type = $request->param('type');

        if (empty($optionId) || !is_array($optionId) || empty($type)){
            return show(config('code.error'), '参数错误', [], 400);
        }

        $model = new \app\admin\model\store\StoreVedioImgRelation();
        $data = $model->OptionDel($uid,$optionId,$type);
        if (!empty($data['msg'])){
            return show(config('code.error'), 'false', $data['msg'], 400);
        }else {
            return show(1, 'success', [], 200);
        }

    }




}

