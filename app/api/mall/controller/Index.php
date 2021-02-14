<?php
namespace app\mall\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends User
{
    /**
     * TODO 渔具商城首页
     * @param string $key
     */
    public function index($key = '')
    {
        $datas = array();
        $info = $this->model_Con->get('mall_index_ad');
        $datas['adv_list'] = array('item' => unserialize($info['value']));
        $token = $this->model_Tk->get(['token' => $key]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
            $datas['my_info'] = array('score' => $this->user_info['score']);
        } else {
            $datas['my_info'] = array('score' => 0);
        }
        $result = $this->model_Mg->Goods_List(0, 2, '', 1, 30);
        $datas['score_list']['item'] = $result['data'];
        $datas['mall_type']['item'] = $this->model_Mt->db()->where('pid', 'neq', '0')->order('sort asc')->select();
        $result = $this->model_Mg->Goods_List(0, 1, '', 1, 30);
        $datas['rmb_list']['item'] = $result['data'];
        $this->data($datas);
    }

    /**
     * 渔具分类
     */
    public function goods_type()
    {
        $datas = array();
        $datas['mall_type'] = $this->model_Mt->db()->where('pid', 'neq', '0')->order('sort asc')->select();
        $this->data($datas);
    }

    /**
     * TODO 渔具列表
     * @param int $type 分页排序类型
     * @param int $typeid 商城分类ID
     * @param int $goods_type 普通商品和鱼古商品类型
     * @param string $keyword 搜索关键词
     * @param string $order 排序方式
     * @param int $curpage 当前页
     * @param int $page_size 每页显示数
     */
    public function goods_list($type = 1, $typeid = 0, $goods_type = 0, $keyword = '', $order = 'desc', $curpage = 1, $page_size = 12)
    {
        $search = array();
        $search['keyword'] = $keyword;
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
        $result = $this->model_Mg->Goods_List($typeid, $goods_type, $order, $curpage, $page_size, $search);
        $datas = array();
        $datas['goods_list'] = $result['data'];
        $this->page($result['page']);
        $this->data($datas);
    }

    /**
     * TODO 渔具详情
     * @param int $goods_id
     * @param string $key
     */
    public function goods_info($goods_id = 1, $key = '')
    {
        $datas = array();
        $datas['goods_info'] = $this->model_Mg->get($goods_id);
        if ($datas['goods_info']) {
            $token = $this->model_Tk->get(['token' => $key]);
            if ($token) {
                $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
                $datas['my_info'] = array('score' => $this->user_info['score']);
            } else {
                $datas['my_info'] = array('score' => 0);
            }
            $datas['goods_info']['like'] = $this->model_Fg->get(['goods_id' => $goods_id, 'user_id' => $this->user_info['id']]) ? 1 : 0;
            $datas['goods_info']['param'] = unserialize($datas['goods_info']['param']);
            $result = $this->model_Mg->Goods_List(0, 1, '', '', 1, 30);

            if (empty($datas['goods_info']['img_list'])) $datas['goods_info']['img_list'] = '/static/images/1-1.jpg';
            $img_list = explode(',', $datas['goods_info']['img_list']);
            $img_list_arr = array();
            foreach ($img_list as $values) {
                $img_list_arr[]['img'] = $values;
            }
            $datas['goods_info']['images_list'] = $img_list_arr;
            $style = unserialize($datas['goods_info']['style']);
            $style_arr = array();
            if (!empty($style)) {
                foreach ($style as $key => $values) {
                    $style_arr[$values['name']][] = ['name' => $values['name'], 'info' => $values['info'], 'price' => $values['price']];
                }
            }
            $style_arr2 = array();
            if (!empty($style_arr)) {
                foreach ($style_arr as $key => $values) {
                    $style_arr2[] = $values;
                }
            }
            $datas['goods_info']['style'] = $style_arr2;
            $datas['goods_info']['recomm_list'] = $result['data'];
            $this->data($datas);
        } else {
            $this->error('该商品可能已经下架！');
        }
    }

    /**
     * TODO 添加购物车
     * @param int $goods_id
     * @param int $goods_num
     * @param int $style_id
     * @param int $style_info_id
     * @throws \think\Exception
     */
    public function cart_add($goods_id = 0, $goods_num = 1, $style_id = 0, $style_info_id = 0)
    {
        if ($goods_num < 1) {
            $this->error('不能小于1的购买量！');
        }
        $check_stock = $this->model_Mg->get($goods_id);
        $this->check_user();
        $this->integral_query('', $this->user_info['gameid'], TIMESTAMP, 0, true);
        $goods_info = $this->model_Cl->get(['goods_id' => $goods_id, 'user_id' => $this->user_info['id'], 'style_id' => $style_id, 'style_info_id' => $style_info_id]);
        $this->model_Cl->db()->startTrans();
        if ($goods_info) {
            if ($check_stock) {
                if ($check_stock['stock'] + $goods_info['goods_num'] < $goods_num) {
                     $this->error('商品库存只剩' . $check_stock['stock'] . '个！');
                }
            }
            $this->model_Cl->save(['goods_num' => $goods_num], ['goods_id' => $goods_id, 'user_id' => $this->user_info['id'], 'style_id' => $style_id, 'style_info_id' => $style_info_id]);
            $this->model_Mg->db()->where('id', 'eq', $goods_id)->setInc('stock', ($goods_info['goods_num'] - $goods_num));
        } else {
            if ($check_stock) {
                if ($check_stock['stock'] < $goods_num) {
                    $this->error('商品库存只剩' . $check_stock['stock'] . '个！');
                }
            }
            $this->model_Cl->save(['goods_id' => $goods_id, 'goods_num' => $goods_num, 'style_id' => $style_id, 'style_info_id' => $style_info_id, 'user_id' => $this->user_info['id']]);
            $this->model_Mg->db()->where('id', 'eq', $goods_id)->setDec('stock', $goods_num);
        }
        $result = $this->model_Cl->Cart_List($this->user_info['id']);
        if ($result['score_price'] > $this->user_info['score']&&$this->user_info['score']!=0) {
            $this->model_Cl->db()->rollback();
            $this->error('您的鱼古不足' . $result['score_price'] . '鱼古！');
        } else {
            $this->model_Cl->db()->commit();
        }
        $this->data(1);
    }

    /**
     * TODO 删除购物车
     * @param int $goods_id
     */
    public function cart_del($goods_id = 0)
    {
        $this->check_user();
        $goods_info = $this->model_Cl->get(['goods_id' => $goods_id, 'user_id' => $this->user_info['id']]);
        if ($goods_info) {
            $this->model_Mg->db()->where('id', 'eq', $goods_id)->setDec('stock', $goods_info['goods_num']);
            $this->model_Cl->destroy(['goods_id' => $goods_id, 'user_id' => $this->user_info['id']]);
            $this->data(1);
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * TODO 购物车
     */
    public function cart_list()
    {
        $this->check_user();
        $datas = array();
        $datas['address_info'] = $this->model_Al->get(['default' => 1, 'user_id' => $this->user_info['id']]);
        $datas['address_info']['address'] = $this->model_R->get_name($datas['address_info']['province']) . $this->model_R->get_name($datas['address_info']['city']) . $this->model_R->get_name($datas['address_info']['county']) . $datas['address_info']['address'];
        $result = $this->model_Cl->Cart_List($this->user_info['id']);
        $datas['cart_list']['item'] = $result['cart_list'];
        $my_score = $this->user_info['score'];
        $datas['pay_info'] = array(
            'my_score' => $my_score,
            'use_score' => $result['score_price'],
            'goods_price' => $result['goods_price'],
            'post_price' => $result['post_price'],
            'pay_price' => round($result['goods_price'] + $result['post_price'], 2));
        $this->data($datas);
    }

    /**
     * TODO 立即付款
     * @param string $trade_type
     */
     public function payment($trade_type = 'JSAPI')
    {
        $this->check_user();
        $result_list = $this->model_Cl->Cart_List($this->user_info['id']);
        $order_sn = build_order_no();
        if ($result_list['score_price'] < $this->user_info['score'] || $result_list['score_price'] > 0) {
            $is_ok = $this->integral_query($order_sn, $this->user_info['gameid'], TIMESTAMP, $result_list['score_price'] * -1);
        }else{
            $is_ok = true;
        }
        if ($is_ok) {
            $datas = array();
            $datas['user_id'] = $this->user_info['id'];
            $datas['order_sn'] = $order_sn;
            $datas['total_rmb_price'] = $result_list['goods_price'];
            $datas['total_score_price'] = $result_list['score_price'];
            $datas['order_state'] = 10;
            $datas['order_postage'] = $result_list['post_price'];
            $datas['address_info'] = serialize($this->model_Al->get(['default' => 1, 'user_id' => $this->user_info['id']])->jsonSerialize());
            $lastid = $this->model_O->save($datas);
            $datas_all = array();
            foreach ($result_list['cart_list'] as $key => $value) {
                $datas = array();
                $datas['order_id'] = $lastid;
                $datas['goods_id'] = $value['id'];
                $datas['goods_num'] = $value['goods_num'];
                $datas['title'] = $value['title'];
                $datas['img'] = $value['img'];
                $datas['rmb_price'] = $value['rmb_price'];
                $datas['score_price'] = $value['score_price'];
                $datas['post_price'] = $value['post_price'];
                $datas['post_price2'] = $value['post_price2'];
                $datas_all[] = $datas;
                $this->model_Mg->db()->where('id', 'eq', $datas['goods_id'])->setInc('sale_num', $datas['goods_num']);
            }
            $this->model_Og->saveAll($datas_all);

            /** 清空购物车 */
            $this->model_Cl->destroy(['user_id' => $this->user_info['id']]);

            $api_pay_amount = round($result_list['goods_price'] + $result_list['post_price'], 2);
            $result = array();
            if ($api_pay_amount == 0) {
                $order_state = $this->model_O->save(['order_state' => 20], ['id' => $lastid]);
                if ($order_state) {
                    $this->model_Ui->save(['score' => ($this->user_info['score'] - $result_list['score_price'])], ['id' => $this->user_info['id']]);
                    $this->model_Sl->save(['user_id' => $this->user_info['id'], 'score' => ($result_list['score_price'] * -1), 'note' => '购物订单：' . $order_sn . '，消费使用' . $result_list['score_price'] . '鱼古']);
                }
                $result['score_pay'] = 1;
            } else {
                $result['score_pay'] = 0;
                $result["paydata"] = $this->wechat->unifiedOrder($this->user_info['linkid'], "狂野钓鱼支付流水号:" . $order_sn, $order_sn, $api_pay_amount, 'http://' . $_SERVER['HTTP_HOST'] . '/api/index/WechatApi/notify_fish', array(), $trade_type);
                $result['error'] = $this->wechat->getError();
            }
            $this->data($result);
        } else {
            $this->error('系统超时！');
        }

    }
}