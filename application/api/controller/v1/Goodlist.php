<?php
namespace app\api\controller\v1;


use app\admin\model\store\StoreProduct;
use app\admin\model\system\SystemGroupData;
use app\admin\model\vedio\Pic;
use app\api\controller\Auth;
use app\routine\model\store\StoreProductAttr;
use think\Request;

class Goodlist extends Auth{


    public function lists(Request $request)
    {
        $name = $request->get('name','');
        $type = $request->get('type','');
        $act = $request->get('act','');
        $model = new StoreProduct();
        if (empty($act)) {
            if (empty($name)) {
                $SystemGroupData = new SystemGroupData();
                $data = $SystemGroupData->HotSearch();
                $name = $data['name'];
            }
        }
        $data = $model -> GoodLists($name,$type);
        return show(1, 'success',$data, 200);
    }


}