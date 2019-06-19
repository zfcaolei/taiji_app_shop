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
use think\Controller;
use think\Request;

//use app\common\lib\exception\ApiException;
//use app\common\lib\Aes;
//use ali\top\TopClient;
//use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
//use app\common\lib\Alidayu;

class Home extends Auth {

    /*
     * 获取首页banner   默认获取首页的baner
     */
    public function Baner(Request $request)
    {
         $cat_id = $request->get('cat_id',0);
        if (empty($cat_id)) {
            $gid = 34;  //首页banner id
            $Model = new SystemGroupData();
            $params = [
                'gid' => 34,
                'status' => 1,
            ];
        }else {
            $cat_data = GetCatDate();
            $params = [
                'gid' => $cat_data['cat_data'][$cat_id]['banner'],
                'status' => 1,
            ];
        }
            $model = new SystemGroupData();
            $data = $model->GetBanerList($params);

        return show(1,'success',$data,200);
    }

    /*
     * 获取商品分类
     */
    public function Cat(Request $request)
    {
        $cat_id = $request->get('cat_id',0);
        $model = new StoreCategory();
        $data = $model->GetCat($cat_id);
        return show(1,'success',$data,200);
        //return $data;
     }


    /*
     * 首页广告图片
     */
     public function Adpic(Request $request)
     {
         $cat_id = $request->get('cat_id',0);
         $gid = 49;  //首页广告图 id
         if (empty($cat_id)) {
             $gid = $gid;  //首页banner id
             $Model = new SystemGroupData();
             $params = [
                 'gid' => $gid,
                 'status' => 1,
             ];
         }else {
             $cat_data = GetCatDate();
             $params = [
                 'gid' => $cat_data['cat_data'][$cat_id]['ad'],
                 'status' => 1,
             ];
         }
         $model = new SystemGroupData();
         $data = $model->GetBanerList($params);
         return show(1,'success',$data,200);
     }



    /*
     * 获取热销商品
     */
    public function Goodhot(Request $request)
    {
        $cat_id = $request->get('cat_id',0);
        $ProductModel =  new StoreProduct();
        $data = $ProductModel->GetGood($cat_id);
        return show(1,'success',$data,200);
    }


    /*
     * 一级页面
     */



    /*
    * 获取精品商品
    */
    public function GoodBest(Request $request)
    {
        $cat_id = $request->get('cat_id',0);
        $ProductModel =  new StoreProduct();
        $data = $ProductModel->Best($cat_id);
        return show(1,'success',$data,200);
    }


    /*
     * 三级页面不同数据
     */
    public function  Catgood(Request $request)
    {
        $CatModel = new StoreCategory();
        $cat_id = $request->get('cat_id',0);
        $CatData = $CatModel->SonCat($cat_id);
        return show(1,'success',$CatData,200);
    }


    /*
     * 获取随机20条商品
     */
    public function GetRandGood()
    {
        $count =  StoreProduct::where(['is_del'=>0])->count();
        $offset = 40;  //每页显示条数
        $length = floor($count/$offset);
        $randNum = rand(1,$length);
        $data = StoreProduct::where(['is_del'=>0])->field(['id','price','image','store_name'])->limit($randNum,$offset)->select();
        return show(1,'success',$data,200);
    }




    /*
     * 热门搜索关键字
     */
    public function HotSearch()
    {
        $model = new SystemGroupData();
        $data = $model->HotSearch();
        return show(1,'success',$data,200);
    }



}

