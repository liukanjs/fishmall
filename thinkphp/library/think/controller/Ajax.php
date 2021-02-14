<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Jinge <admin@cnbbx.com>
// +----------------------------------------------------------------------
namespace think\controller;

/**
 * ThinkPHP Ajax控制器类
 */
class Ajax
{

    protected $page_info = null;


    /**
     * 架构函数
     * @access public
     */
    public function __construct()
    {
    }

    /**
     * 魔术方法 有不存在的操作的时候执行
     * @access public
     * @param string $method 方法名
     * @param array $args 参数
     * @return mixed
     */
    public function __call($method, $args)
    {
    }

    /**
     * 输出正常的数据
     * @param $datas
     * @param array $extend_data
     */
    public function data($datas, $extend_data = array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array();
        $data['code'] = 1;
        if (!empty($extend_data)) {
            $data = array_merge($data, $extend_data);
        }
        if (!empty($this->page_info)) {
            $data = array_merge($data, $this->page_info);
        }
        if (!empty($datas)) $data['datas'] = $datas;
        if (!empty($_GET['callback'])) {
            echo $_GET['callback'] . '(' . json_encode($data) . ')';
            die;
        } else {
            echo json_encode($data);
            die;
        }
    }

    /**
     * 输出错误的数据
     * @param $message
     * @param array $extend_data
     */
    public function error($message, $extend_data = array())
    {
        $datas = array();
        $datas['code'] = 0;
        $datas['error'] = $message;
        Ajax::data($extend_data, $datas);
    }

    /**
     * 输出分页数据
     * @param $page_count
     * @return array
     */
    public function page($page_count)
    {
        // TODO 输出是否有下一页
        $extend_data = array();
        if (!empty($_GET['curpage'])) {
            $current_page = intval($_GET['curpage']);
        } else {
            $current_page = 1;
        }
        if ($current_page >= $page_count) {
            $extend_data['hasmore'] = false;
        } else {
            $extend_data['hasmore'] = true;
        }
        $extend_data['page_total'] = $page_count;
        $this->page_info = $extend_data;
    }
}
