<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Request;

defined('InCnbbx') or exit('Access Invalid!');

class Mall extends Admin
{

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index($type = 1, $typeid = 0, $goods_type = 0, $keyword = '', $order = 'desc', $curpage = 1, $page_size = 12)
    {
        return $this->goods_index($type, $typeid, $goods_type, $keyword, $order, $curpage, $page_size);
    }

    public function goods_index($type = 1, $typeid = 0, $goods_type = 0, $keyword = '', $order = 'desc', $curpage = 1, $page_size = 12)
    {
        if ($order == 'asc')
            $order = 'asc';
        else
            $order = 'desc';
        switch ($type) {
            case 1://综合
                $order = 'id ' . $order;
                break;
            case 2://销量
                $order = 'sale_num ' . $order;
                break;
            case 3://价格
                $order = 'rmb_price ' . $order . ', score_price ' . $order;
                break;
            case 4://人气
                $order = 'stock ' . $order;
                break;
        }
        $search['keyword'] = $keyword;
        $result = $this->model_Mg->Goods_List($typeid, $goods_type, $order, $curpage, $page_size, $search);
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch('goods_index');
    }

    /**
     * TODO 发布商品
     * @param int $id
     * @return mixed
     */
    public function goods_add($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            $style = array();
            foreach ($poster['style_name'] as $key => $value) {
                $style[] = ['name' => $poster['style_name'][$key], 'info' => $poster['style_info'][$key], 'price' => $poster['style_price'][$key]];
            }
            unset($poster['style_name']);
            unset($poster['style_info']);
            unset($poster['style_price']);
            $poster['style'] = serialize($style);
            $param = array();
            foreach ($poster['name'] as $key => $value) {
                $param[] = ['name' => $poster['name'][$key], 'info' => $poster['info'][$key]];
            }
            unset($poster['name']);
            unset($poster['info']);
            unset($poster['type']);
            $poster['param'] = serialize($param);
            $result = $id ? $this->model_Mg->save($poster, ['id' => $id]) : $this->model_Mg->save($poster);
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Mg->get($id);
        if (!empty($info)) {
            $info['images_list'] = explode(',', $info['img_list']);
            $info['style'] = unserialize($info['style']);
            $info['param'] = unserialize($info['param']);
        }
        $type = $this->model_Mt->db()->where('pid', 'eq', 0)->order('sort asc')->select();
        $this->assign('type', $type);
        $type2 = $this->model_Mt->db()->where('pid', 'neq', 0)->order('sort asc')->select();
        $this->assign('type2', $type2);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 删除商品
     * @param int $id
     */
    public function goods_del($id = 0)
    {
        $result = $this->model_Mg->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 上下架产品
     * @param int $id
     */
    public function goods_down($id = 0)
    {
        $istop = $this->model_Mg->get(['issale' => 1, 'id' => $id]);
        if ($istop) {
            $result = $this->model_Mg->save(['issale' => 0], ['id' => $id]);
            $this->ajax->data(2);
        } else {
            $result = $this->model_Mg->save(['issale' => 1], ['id' => $id]);
            $this->ajax->data(1);
        }
        if (!$result) $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 商城分类
     * @return mixed
     */
    public function class_index()
    {
        $list = $this->model_Mt->db()->where('pid', 'eq', 0)->order('sort asc')->select();
        foreach ($list as $key => $value) {
            $list[$key]['son'] = $this->model_Mt->db()->where('pid', 'eq', $value['id'])->order('sort asc')->select();
        }
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * TODO 编辑分类
     * @param int $id
     * @param bool $add
     * @return mixed
     */
    public function class_edit($id = 0, $add = false)
    {
        $info = $this->model_Mt->get($id);
        $this->assign('info', $info);
        $list = $this->model_Mt->all(['pid' => 0]);
        $this->assign('list', $list);
        if ($add) {
            $id = 0;
        } else {
            $_GET['add'] = false;
        }
        if (chksubmit()) {
            if ($add) {
                $_POST['level'] = $info['level'] + 1;
            } else {
                $info = $this->model_Mt->get($_POST['pid']);
                $_POST['level'] = $info['level'] + 1;
            }
            $result = $id ? $this->model_Mt->save(input('post.'), ['id' => $id]) : $this->model_Mt->save(input('post.'));
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        return $this->fetch();
    }

    /**
     * TODO 删除分类
     * @param int $id
     */
    public function class_del($id = 0)
    {
        $result = $this->model_Mt->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 商城设置
     * @return mixed
     */
    public function set_index()
    {
        if (chksubmit()) {
            $poster = input('post.');
            $datas = [];
            if (isset($poster['url1'])) $datas[] = ['image' => $poster['image1'], 'url' => $poster['url1']];
            if (isset($poster['url2'])) $datas[] = ['image' => $poster['image2'], 'url' => $poster['url2']];
            if (isset($poster['url3'])) $datas[] = ['image' => $poster['image3'], 'url' => $poster['url3']];
            if (isset($poster['url4'])) $datas[] = ['image' => $poster['image4'], 'url' => $poster['url4']];
            $this->model_Con->save(['value' => serialize($datas)], ['name' => 'mall_index_ad']);
            $this->ajax->data(1);
        }
        $info = $this->model_Con->get('mall_index_ad');
        $info['item_data'] = unserialize($info['value']);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 订单首页
     * @param int $user_id
     * @param int $curpage
     * @param int $page_size
     * @return mixed
     */
    public function order_index($user_id = 0, $curpage = 1, $page_size = 20)
    {
        if (empty($_GET['state'])) {
            $_GET['state'] = '';
        }
        if (empty($_GET['keyword'])) {
            $_GET['keyword'] = '';
        }
        $search = input('get.');
        $search['show_goods'] = true;
        $result = $this->model_O->getOrderList($user_id, $curpage, $page_size, $search);
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch();
    }

    /**
     * TODO 订单详情
     * @param int $id
     * @return mixed
     */
    public function order_info($id = 0)
    {
        $order_info = $this->model_O->get(['id' => $id]);
        $province = unserialize($order_info['address_info'])['province'];
        $city = unserialize($order_info['address_info'])['city'];
        $county = unserialize($order_info['address_info'])['county'];

        $address='';
        $address.=$this->model_R->where('region_id',$province)->value('region_name');
        $address.=$this->model_R->where('region_id',$city)->value('region_name');
        $address.=$this->model_R->where('region_id',$county)->value('region_name');


        $address_info = unserialize($order_info['address_info']);
        $address_info['address']=$address.'&nbsp;&nbsp;&nbsp;'.$address_info['address'];
        $order_info['address_info'] =$address_info;

        $order_info['order_goods_list'] = $this->model_Og->all(['order_id' => $id]);
        $datas = array();

        $datas['order_info'] = $order_info;


        var_dump($order_info);
        $datas['order_info']['total_pay_price'] = $order_info['total_rmb_price'] + $order_info['order_postage'];
        $this->assign('result', $datas);
        return $this->fetch();
    }

    /**
     * TODO 发货单
     * @param int $id
     * @return mixed
     */
    public function order_out($id = 0)
    {
        $order_info = $this->model_O->get(['id' => $id]);
        $order_info['address_info'] = unserialize($order_info['address_info']);
        $order_info['order_goods_list'] = $this->model_Og->all(['order_id' => $id]);
        $datas = array();
        $datas['order_info'] = $order_info;
        $datas['order_info']['total_pay_price'] = $order_info['total_rmb_price'] + $order_info['order_postage'];
        $this->assign('result', $datas);
        return $this->fetch();
    }

    /**
     * TODO 发快递填写单号
     * @param int $id
     * @param int $deliver_sn
     * @return array|void
     */
    public function order_send($id = 0, $deliver_sn = 0)
    {
        //$order_info = $this->model_O->get(['id' => $id]);
        //$info = $this->model_Ui->get($order_info['user_id']);
        //$this->order_send_query($order_info['order_sn'], $info['gameid'], $info['score'], TIMESTAMP);
        $result = $this->model_O->save(['deliver_sn' => $deliver_sn, 'deliver_time' => TIMESTAMP, 'order_state' => 30], ['id' => $id]);
        if ($result) {
            return $this->success('发货成功！');
        } else
            return $this->error('操作失败，稍后重试！');
    }
}