<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;
//require_once EXTEND_PATH.'qiniu/autoload.php';
use Ali\Core\Config;
use alisms\SendSms;
use app\admin\model\store\StoreCategory;
use app\admin\model\store\StoreProduct;
use app\admin\model\store\StroeProduct3dFile;
use app\admin\model\system\SystemGroupData;
use app\admin\model\user\ApiUser;
use app\api\controller\Auth;
use app\common\lib\AliSms;
use app\common\lib\Sms;
use app\common\model\AppUser;
use app\routine\model\store\StoreProductAttr;
use app\routine\model\store\StoreProductRelation;
use app\routine\model\store\StoreProductReply;
use Qiniu\Storage\UploadManager;
use service\JsonService;
use service\UtilService;
use think\Controller;
use think\Request;

//use app\common\lib\exception\ApiException;
//use app\common\lib\Aes;
//use ali\top\TopClient;
//use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
//use app\common\lib\Alidayu;

class Good extends Auth {

    /**
     * 商品详情页
     * @param Request $request
     */
    public function details(Request $request){
       // $data = UtilService::postMore(['id'],$request);
        $id =$request->get('id');
        if (empty($id)){
            return show(config('code.error'), '参数错误', [], 400);
        }
        if(!$id || !($storeInfo = \app\routine\model\store\StoreProduct::getValidProduct($id,'id,cate_id,image,slider_image,store_name,store_info,keyword,price,ot_price,postage,unit_name,stock,sales,description'))) return show(config('code.error'), '商品不存在或已下架', [], 400);
        $storeInfo['userCollect'] = StoreProductRelation::isProductRelation($id,$this->user->id,'collect');

        list($productAttr,$productValue) = StoreProductAttr::getProductAttrDetail($id);

        setView($this->user->id,$id,$storeInfo['cate_id'],'viwe');
        foreach ($productAttr as $k=>$v){
            $attr = $v['attr_values'];
//            unset($productAttr[$k]['attr_values']);
            foreach ($attr as $kk=>$vv){
                $productAttr[$k]['attr_value'][$kk]['attr'] =  $vv;
                //$productAttr[$k]['attr_value'][$kk]['check'] =  false;
            }
        }

        $data['storeInfo'] = $storeInfo;
        $Product3D = new StroeProduct3dFile();
        $data['storeInfo']['3d_file'] = $Product3D ->GetFile3D($id);  //3d图
       // $data['similarity'] = StoreProduct::cateIdBySimilarityProduct($storeInfo['cate_id'],'id,store_name,image,price,sales,ficti',4); //cateIdBySimilarityProduct
        $data['productAttr'] = $productAttr;
        $data['productValue'] = $productValue;
        $data['reply'] = StoreProductReply::getRecProductReply($storeInfo['id']);
        $data['replyCount'] = StoreProductReply::productValidWhere()->where('product_id',$storeInfo['id'])->count();
       // $data['mer_id'] = StoreProduct::where('id',$storeInfo['id'])->value('mer_id');
       return show(1, 'success', $data, 200);
    }



    /**
     * 获取商品属性数据
     * @param string $productId
     * @return \think\response\Json
     */
    public function ProductAttrDetail($productId = '')
    {
        if(!$productId || !is_numeric($productId)) return show(config('code.error'), '参数错误', [], 400);
        list($productAttr,$productValue) = StoreProductAttr::getProductAttrDetail($productId);
        //return JsonService::successful(compact('productAttr','productValue'));
        return show(1, 'success',compact('productAttr','productValue'), 200);

    }

    //安卓端使用
    public function ProductAttrDetailAndroid($productId = '')
    {
        if(!$productId || !is_numeric($productId)) return show(config('code.error'), '参数错误', [], 400);
        list($productAttr,$productValue) = StoreProductAttr::getProductAttrDetailtest($productId);
        //return JsonService::successful(compact('productAttr','productValue'));
        return show(1, 'success',compact('productAttr','productValue'), 200);

    }





    public function productReplyList($productId = '',$first = 0,$limit = 8, $filter = 'all')
    {
        if(!$productId || !is_numeric($productId)) return show(config('code.error'), '参数错误', [], 400);

        $list = StoreProductReply::getProductReplyList($productId,$filter,$first,$limit);

        if($list){
            foreach ($list as $k=>$v){
                foreach ($v['pics'] as $kk=>$vv){
                    $list[$k]['pics'] = explode(',',$vv);
                }
            }
        }
        return show(1, 'success',$list, 200);

    }



//    public function Test()
//    {
//
//        // 用于签名的公钥和私钥
//        $accessKey = '_g0MZcoZWZm49rr9NRWvMEwc3bPC09G4Yrffld0o';
//        $secretKey = '7ggDwgqb5jALg68Nl6QjHc5ZKA6OZINOM_nBh0_K';
//        // 初始化签权对象
//        $auth = new \Qiniu\Auth($accessKey, $secretKey);
//
//        $bucket='tjkj';//存储空间
//        $token = $auth->uploadToken($bucket);
//        $uploadMgr = new UploadManager();
//        $filePath = $_FILES['image']['tmp_name'];//'./php-logo.png';  //接收图片信息
//        if($_FILES['image']['type']=='video/mp4'){
//            $key = 'video'.time().'.mp4';
//        }elseif($_FILES['image']['type']=='audio/mp3'){
//            $key = 'audio'.time().'.mp3';
//        }else{
//            $key = 'png'.time().'.png';
//        }
//        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//        if ($err !== null) {
//            echo '上传失败';
//        } else{
//            print_r($ret['key']);
//        }
//
//
//    }


}

