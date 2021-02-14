<?php
namespace app\index\controller;

use think\controller\Ajax;
use think\Request;

defined('InCnbbx') or exit('Access Invalid!');

class City extends Ajax
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    
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