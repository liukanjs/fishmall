<?php
namespace app\index\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends User
{
    /**
     * TODO 微信端综合首页
     */
    public function index()
    {
        $datas = array();
        $item = model('special_item')->get(1);
        $datas['adv_list'] = array('item' => unserialize($item['item_data']));
        $item = model('special_item')->get(2);
        $datas['nav_list'] = array('item' => unserialize($item['item_data']));
        $item = model('special_item')->get(3);
        $datas['pic3_list'] = unserialize($item['item_data']);
        $item = model('special_item')->get(4);
        $item_data = unserialize($item['item_data']);
        $result = $this->model_Fal->getArticleList(0, 2, 3, 1, $item_data['len'], ['ishome' => 1]);
        $datas['active_list'] = array('title' => $item_data['title'], 'more_url' => './forum/activity.html', 'item' => $result['data']);
        $item = model('special_item')->get(5);
        $item_data = unserialize($item['item_data']);
        $result = $this->model_Fal->getArticleList(0, 1, 2, 1, $item_data['len'], ['ishome' => 1]);
        $datas['strategy_list'] = array('title' => $item_data['title'], 'more_url' => './forum/index.html', 'item' => $result['data']);
        $this->data($datas);
    }

    /**
     * TODO 设置收藏（1：成功  2：取消）
     * @param int $id
     */
    public function set_like($id = 0)
    {
        $this->check_user();
        $token = $this->model_Fg->get(['goods_id' => $id, 'user_id' => $this->user_info['id']]);
        if ($token) {
            $this->model_Fg->destroy(['goods_id' => $id, 'user_id' => $this->user_info['id']]);
            $this->data(2);
        } else {
            $this->model_Fg->save(['goods_id' => $id, 'user_id' => $this->user_info['id']]);
            $this->data(1);
        }
    }

    /**
     * TODO 点赞接口（1：成功  2：取消）
     * @param int $id
     * @param int $type
     */
    public function set_praise($id = 0, $type = 1)
    {
        $this->check_user();
        $token = $this->model_Prl->get(['art_id' => $id, 'type' => $type, 'user_id' => $this->user_info['id']]);
        if ($token) {
            $this->model_Prl->destroy(['art_id' => $id, 'type' => $type, 'user_id' => $this->user_info['id']]);
            $this->data(2);
        } else {
            $this->model_Prl->save(['art_id' => $id, 'type' => $type, 'user_id' => $this->user_info['id']]);
            $this->data(1);
        }
    }

    /**
     * TODO 评论接口
     */
    public function get_discuss_list()
    {
        $this->check_user();
        $postarr = input('post.');
        if (empty($postarr['type'])) $postarr['type'] = 1;
        $this->model_Dl->save(['art_id' => $postarr['id'], 'type' => $postarr['type'], 'messages' => $postarr['messages'], 'user_id' => $this->user_info['id']]);
        $datas['discuss_list']['item'] = $this->model_Dl->Discuss_List($postarr['id'], $postarr['type']);
        $this->data($datas);
    }
}