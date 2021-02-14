<?php
namespace app\place\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends User
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO 钓场首页
     * @param int $type
     * @param int $city_id
     * @param int $curpage
     * @param int $page_size
     * @param string $order
     * @param int $lat
     * @param int $lng
     */
    public function index($type = 1, $city_id = 0, $curpage = 1, $page_size = 12, $order = 'asc', $lat = 0, $lng = 0)
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
        $datas = array();
        $datas['place_list'] = $result['data'];
        $this->page($result['page']);
        $this->data($datas);
    }

    /**
     * TODO 钓场详情
     * @param int $place_id
     * @param string $key
     */
    public function place_info($place_id = 1, $key = '')
    {
        $token = $this->model_Tk->get(['token' => $key]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
            $result = $this->model_I->get(['art_id' => $place_id, 'type' => 2, 'user_id' => $this->user_info['id']]);
            if (!$result) {
                $this->model_I->save(['art_id' => $place_id, 'type' => 2, 'user_id' => $this->user_info['id']]);
            }
        }
        $Place_Info = $this->model_Pl->get($place_id);
        $datas = array();
        $datas['place'] = array(
            'id' => $place_id,
            'like' => 1,
            'title' => $Place_Info['title'],
            'user_name' => '',
            'user_tel' => $Place_Info['telphone'],
            'address' => $Place_Info['address'],
            'fish_name' => $Place_Info['tags'],
            'price' => $Place_Info['price'],
            'content' => $Place_Info['content'],
            'service' => $Place_Info['service'],
            'img' => $Place_Info['img']);
        $datas['top_list']['item'] = $this->model_I->Interest_List($place_id, 2);
        $datas['discuss_list']['item'] = $this->model_Dl->Discuss_List($place_id, 2);
        $datas['my_info'] = array('user_icon' => '../static/images/head.gif');
        $this->data($datas);
    }

    /**
     * TODO 获取钓场类型
     */
    public function get_place_type()
    {
        $datas['place_type'][] = array('id' => 1, 'name' => '钓场');
        $datas['place_type'][] = array('id' => 2, 'name' => '店铺');
        $this->data($datas);
    }

    /**
     * TODO 获取钓场类型
     */
    public function get_place_city()
    {
        $this->data($this->model_Fc->all());
    }

    /**
     * TODO 发布钓场
     */
    public function place_add()
    {
        $this->check_user();
        $postarr = input('post.');
        if ($this->model_Fal->filter($postarr['note'])) {
            $datas = array();
            $datas['typeid'] = $postarr['type'];
            $datas['user_id'] = $this->user_info['id'];
            $datas['province'] = $postarr['province'];
            $datas['city'] = $postarr['city'];
            $datas['county'] = $postarr['county'];
            $datas['address'] = $postarr['address'];
            $datas['title'] = $postarr['title'];
            $datas['telphone'] = $postarr['tel'];
            $datas['price'] = $postarr['price'];
            $datas['service'] = $postarr['service'];
            $datas['tags'] = $postarr['fish_name'];
            $datas['content'] = $postarr['note'];
            if (empty($postarr['img'])) {
                $datas['img'] = '/static/images/1-1.jpg';
            } else {
                $datas['img'] = $postarr['img'];
            }
            $this->model_Pl->save($datas);
            $this->data(1);
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }

    /**
     * TODO 认领钓场
     */
    public function place_set()
    {
        $this->check_user();
        $this->data(1);
    }
}