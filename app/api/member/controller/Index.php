<?php
namespace app\member\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends User
{
    /**
     * TODO 会员中心首页
     */
    public function index()
    {
        $this->check_user();
        $this->integral_query('', $this->user_info['gameid'], TIMESTAMP, 0, true);
        $datas = array();
        $datas['my_info'] = array('id' => $this->user_info['id'], 'level' => 'lv' . $this->user_info['level'], 'user_icon' => $this->user_info['user_icon'], 'user_name' => $this->user_info['user_name'], 'score' => $this->user_info['score'], 'mylike' => $this->model_Fg->db()->where('user_id', 'eq', $this->user_info['id'])->count());
        $this->data($datas);
    }

    /**
     * TODO 修改会员资料
     */
    public function user_edit()
    {
        $this->check_user();
        $postarr = input('post.');
        if ($this->model_Fal->filter($postarr['user_name'])) {
            $this->model_Ui->save(['user_name' => $postarr['user_name'], 'user_icon' => $postarr['user_icon']], ['id' => $this->user_info['id']]);
            $this->data(1);
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }

    /**
     * TODO 收藏商品
     */
    public function fav_goods()
    {
        $this->check_user();
        $datas = array();
        $fav_list = $this->model_Fg->db()->where('user_id', 'eq', $this->user_info['id'])->order('id desc')->select();
        foreach ($fav_list as $key => $value) {
            $goods_info = $this->model_Mg->get(['id' => $value['goods_id']]);
            if (empty($goods_info['img_list'])) {
                $fav_list[$key]['img'] = '/static/images/1-1.jpg';
            } else {
                $img = explode(',', $goods_info['img_list']);
                $fav_list[$key]['img'] = $img[0];
            }
            $fav_list[$key]['title'] = $goods_info['title'];
            $fav_list[$key]['rmb_price'] = $goods_info['rmb_price'];
            $fav_list[$key]['score_price'] = $goods_info['score_price'];
            $fav_list[$key]['sale_num'] = $goods_info['sale_num'];
        }
        $datas['fav_goods'] = $fav_list;
        $this->page(1);
        $this->data($datas);
    }

    /**
     * TODO 我的鱼古
     */
    public function score_list()
    {
        $this->check_user();
        $datas = array();
        $datas['score_list'] = $this->model_Sl->db()->where('user_id', 'eq', $this->user_info['id'])->order('id desc')->select();
        $this->page(1);
        $this->data($datas);
    }

    /**
     * TODO 我的订单
     * @param int $curpage
     * @param int $page_size
     */
    public function order_list($curpage = 1, $page_size = 12)
    {
        $this->check_user();
        $result = $this->model_O->getOrderList($this->user_info['id'], $curpage, $page_size);
        $datas = array();
        $datas['order_list'] = $result['data'];
        $this->page($result['page']);
        $this->data($datas);
    }

    /**
     * TODO 订单详情
     * @param int $id
     */
    public function order_info($id = 1)
    {
        $this->check_user();
        $order_info = $this->model_O->get(['id' => $id, 'user_id' => $this->user_info['id']]);
        $order_info['address_info'] = unserialize($order_info['address_info']);
        $order_info['order_goods_list'] = $this->model_Og->all(['order_id' => $id]);
        $datas = array();
        $datas['order_info'] = $order_info;
        $datas['order_info']['total_pay_price'] = $order_info['total_rmb_price'] + $order_info['order_postage'];
        $this->data($datas);
    }

    /**
     * TODO 取消订单
     * @param int $id
     */
    public function order_can($id = 1)
    {
        $this->check_user();
        $order_info = $this->model_O->get(['id' => $id, 'user_id' => $this->user_info['id']]);
        if ($order_info) {
            if ($order_info['order_state'] == 10) {
                $this->model_O->save(['order_state' => 0], ['id' => $id, 'user_id' => $this->user_info['id']]);
            }
        }
        $this->data(1);
    }

    /**
     * TODO 删除订单
     * @param int $id
     */
    public function order_del($id = 1)
    {
        $this->check_user();
        $order_info = $this->model_O->get(['id' => $id, 'user_id' => $this->user_info['id']]);
        if ($order_info) {
            if ($order_info['order_state'] == 0) {
                $result = $this->model_O->destroy(['id' => $id, 'user_id' => $this->user_info['id']]);
                if ($result) {
                    $this->model_Og->destroy(['order_id' => $id]);
                }
            }
        }
        $this->data(1);
    }

    /**
     * TODO 二次付款
     * @param int $id
     */
    public function order_pay($id = 1)
    {
        $this->check_user();
        $order_info = $this->model_O->get(['id' => $id, 'user_id' => $this->user_info['id']]);
        $api_pay_amount = $order_info['total_rmb_price'] + $order_info['order_postage'];
        if ($order_info['total_score_price'] <= $this->user_info['score']) {
            $result = array();
            $result["paydata"] = $this->wechat->unifiedOrder($this->user_info['linkid'], "狂野钓鱼支付流水号:" . $order_info['order_sn'], $order_info['order_sn'], $api_pay_amount, 'http://' . $_SERVER['HTTP_HOST'] . '/api/index/WechatApi/notify_fish', array(), 'JSAPI');
            $result['error'] = $this->wechat->getError();
            $this->data($result);
        } else {
            $this->error('鱼古不足！');
        }
    }

    /**
     * TODO 会员地址列表
     */
    public function address_list()
    {
        $this->check_user();
        $address_list = $this->model_Al->all(['user_id' => $this->user_info['id']]);
        if (isset($address_list)) {
            foreach ($address_list as $key => $value) {
                $address_list[$key]['address'] = $this->model_R->get_name($value['province']) . $this->model_R->get_name($value['city']) . $this->model_R->get_name($value['county']) . $value['address'];
            }
        }
        $this->data(array('address_list' => $address_list));
    }

    /**
     * TODO 获取单个地址
     * @param int $id
     */
    public function address_get($id = 0)
    {
        $this->check_user();
        $address_info = $this->model_Al->get($id);
        $this->data(array('address_info' => $address_info));
    }

    /**
     * TODO 添加会员地址
     */
    public function address_add()
    {
        $this->check_user();
        $datas = input('post.');
        unset($datas['key']);
        $datas['user_id'] = $this->user_info['id'];
        $result = input('?post.id') ? $this->model_Al->save($datas, ['id' => $datas['id'], 'user_id' => $this->user_info['id']]) : $this->model_Al->save($datas);
        $this->model_Al->save(['default' => 0], ['user_id' => $this->user_info['id']]);
        $this->model_Al->save(['default' => 1], ['id' => $result, 'user_id' => $this->user_info['id']]);
        if (!empty($result))
            $this->data(1);
        else
            $this->error('操作失败，稍后重试！');
    }

    /**
     * TODO 删除会员地址
     * @param int $id
     */
    public function address_del($id = 0)
    {
        $this->check_user();
        $result = $this->model_Al->destroy(['id' => $id, 'user_id' => $this->user_info['id']]);
        if (!empty($result))
            $this->data(1);
        else
            $this->error('操作失败，稍后重试！');
    }

    /**
     * TODO 设置默认地址
     * @param int $id
     */
    public function address_default($id = 0)
    {
        $this->check_user();
        $this->model_Al->save(['default' => 0], ['user_id' => $this->user_info['id']]);
        $result = $this->model_Al->save(['default' => 1], ['id' => $id, 'user_id' => $this->user_info['id']]);
        if (!empty($result))
            $this->data(1);
        else
            $this->error('操作失败，稍后重试！');
    }

}