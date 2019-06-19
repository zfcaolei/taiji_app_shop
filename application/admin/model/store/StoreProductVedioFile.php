<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/11
 */

namespace app\admin\model\store;

use app\admin\model\store\StoreCategory as CategoryModel;
use app\routine\model\store\StoreCart;
use app\routine\model\store\StoreCategory;
use service\PHPExcelService;
use think\Db;
use traits\ModelTrait;
use basic\ModelBasic;
use app\admin\model\order\StoreOrder;
use app\admin\model\system\SystemConfig;

/**
 * 商品视频模型 model
 * Class StoreProduct
 * @package app\admin\model\store
 */
class StoreProductVedioFile extends ModelBasic
{
    use ModelTrait;
    protected $table = 'eb_store_product_vedio_file';


    public function GetFileVedio($id)
    {
        $data = self::where(['product_id'=>$id])->field('vedio_url')->find();
        if (!empty($data)){
            $res = config('qn.url').'/'.$data['vedio_url'];
        }else{
            $res = '';
        }
        return $res;
    }


}