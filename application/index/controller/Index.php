<?php
namespace app\index\controller;





use app\admin\model\user\ApiUser;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        var_dump(33333333333);
     }


    public function tests()
    {
         $model = new ApiUser();
         var_dump($model->Test());
    }
}


