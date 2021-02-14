<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Request;

defined('InCnbbx') or exit('Access Invalid!');

class Angling extends Admin
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index($type = 1, $city_id = 0, $curpage = 1, $page_size = 12, $order = 'desc', $lat = 0, $lng = 0)
    {
        return $this->angling_index($type, $city_id, $curpage, $page_size, $order, $lat, $lng);
    }

    public function angling_index($type = 1, $city_id = 0, $curpage = 1, $page_size = 12, $order = 'desc', $lat = 0, $lng = 0)
    {
        if ($order == 'asc')
            $order = 'asc';
        else
            $order = 'desc';
        switch ($type) {
            case 1:
                $order = 'id ' . $order;
                break;
            case 2:
                $order = 'distance ' . $order;
                break;
            case 3:
                $order = 'price ' . $order;
                break;
            case 4:
                $order = 'bus ' . $order;
                break;
        }
        $result = $this->model_Pl->Place_List($order, $city_id, $lat, $lng, $curpage, $page_size);
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch('angling_index');
    }

    /**
     * TODO 钓场编辑
     * @param int $id
     * @return mixed
     */
    public function angling_edit($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            $result = $id ? $this->model_Pl->save($poster, ['id' => $id]) : $this->model_Pl->save($poster);
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Pl->get($id);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 钓场删除
     * @param int $id
     */
    public function angling_del($id = 0)
    {
        $result = $this->model_Pl->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    public function city_index($id = 0)
    {
        $ajax = new Ajax;
        if (chksubmit()) {
            $result = $id ? $this->model_Fc->save(input('post.'), ['id' => $id]) : $this->model_Fc->save(input('post.'));
            if (!empty($result))
                $ajax->data(1);
            else
                $ajax->error('操作失败，稍后重试！');
        }
        $list = $this->model_Fc->all();
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function city_del($id = 0)
    {
        $ajax = new Ajax;
        $model_city = new CITY;
        $result = $model_city->destroy(['id' => $id]);
        if ($result)
            $ajax->data(1);
        else
            $ajax->error('操作失败，稍后重试！');
    }

    public function services_index()
    {
        return $this->fetch();
    }
}