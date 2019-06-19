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
 * 商品3D文件 model
 * Class StoreProduct
 * @package app\admin\model\store
 */
class StroeProduct3dFile extends ModelBasic
{
    use ModelTrait;
    protected $table = 'eb_stroe_product_3d_file';




    public function GetFile3D($id)
    {
        $data = self::where(['product_id'=>$id])->field('file_name')->find();
        if (!empty($data)){
            $res = config('qn.url').'/'.$data['file_name'];
        }else{
            $res = '';
        }
        return $res;
    }


}