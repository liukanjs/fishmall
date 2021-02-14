<?php
namespace app\index\controller;

use think\controller\Ajax;
use think\Db;

class City extends Ajax
{
    /**
     * TODO 获取全部地址
     */
    public function index()
    {
        $region = logic('Region');
        $datas = $region->get_city_all();
        $this->data($datas);
    }
}