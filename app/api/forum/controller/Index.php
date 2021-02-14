<?php
namespace app\forum\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends User
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO 社区首页-论坛列表
     * @param int $typeid
     * @param int $ctype
     * @param int $atype
     * @param int $curpage
     * @param int $page_size
     * @param bool $ismy
     * @param string $key
     */
    public function index($typeid = 1, $ctype = 1, $atype = 1, $curpage = 1, $page_size = 12, $ismy = false, $key = '')
    {
        switch ($typeid) {
            case 1:
                // TODO 最新
                $result = $this->model_Fal->getNewArticleList($curpage, $page_size, $ismy);
                break;
            case 2:
                // TODO 精华
                $result = $this->model_Fal->getArticleList(0, 1, 2, $curpage, $page_size);
                break;
            case 7:
                // TODO 活动最新
                $result = $this->model_Fal->getArticleList(0, 2, 3, $curpage, $page_size);
                break;
            default:
                // TODO 其他栏目
                $result = $this->model_Fal->getArticleList($typeid, $ctype, $atype, $curpage, $page_size);
                break;
        }
        $token = $this->model_Tk->get(['token' => $key]);
        if ($token) {
            foreach ($result['data'] as $key => $value) {
                $result['data'][$key]['ismy'] = ($token['linkid'] == $value['mobile']) ? 1 : 0;
                unset($result['data'][$key]['mobile']);
            }
        }
        $datas['strategy_list'] = $result['data'];
        $this->page($result['page']);
        $this->data($datas);
    }

    /**
     * TODO 获取社区栏目
     * @param int $ctype
     * @param int $atype
     */
    public function nav_type($ctype = 0, $atype = 0)
    {
        if ($ctype != 0 && $atype == 0) {
            $this->data(array('class_type' => $this->model_Fnt->where('ctype',$ctype)->order('sort asc')->select()));
        } else if ($ctype == 0 && $ctype == 0) {
            $this->data(array('class_type' => $this->model_Fnt->where('id','gt',0)->order('sort asc')->select()));
        } else {
            $this->data(array('class_type' => $this->model_Fnt->all(['ctype' => $ctype, 'atype' => $atype, 'id' => array('not in', '1,2')])));
            $this->data(array('class_type' => $this->model_Fnt->where('ctype', $ctype)->where('atype' , $atype)->where('id','not in','1,2') ->order('sort asc')->select()));
        }
    }

    /**
     * TODO 获取文章分类接口
     * @param int $typeid
     */
    public function article_type($typeid = 0)
    {
        if ($typeid == 0) {
            $this->data(array('article_list' => $this->model_Ft->all()));
        } else {
            $this->data(array('article_list' => $this->model_Ft->all(['typeid' => $typeid])));
        }
    }

    /**
     * TODO 话题详情页
     * @param int $topic_id
     * @param string $key
     */
    public function topic_info($topic_id = 1, $key = '')
    {
        $token = $this->model_Tk->get(['token' => $key]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
            $result = $this->model_I->get(['art_id' => $topic_id, 'type' => 1, 'user_id' => $this->user_info['id']]);
            if (!$result) {
                $this->model_I->save(['art_id' => $topic_id, 'type' => 1, 'user_id' => $this->user_info['id']]);
            }
        }
        $Topic = $this->model_Fal->get($topic_id);
        $UserInfo = $this->model_Ui->get(['id' => $Topic['m_id']]);
        $img_list = explode(',', $Topic['image']);
        foreach ($img_list as $values) {
            $img_list_arr[]['img'] = $values;
        }
        $datas = array();
        $datas['topic'] = array(
            'id' => $topic_id,
            'like' => $this->model_Prl->get_praise_state($topic_id, 1),
            'user_icon' => $UserInfo['user_icon'],
            'user_name' => $UserInfo['user_name'],
            'last_time' => mdate(to_timespan($Topic['create_time'])),
            'content' => $Topic['content'],
            'img_list' => $img_list_arr,
            'address' => $Topic['address'],
            'top_num' => 0,
            'discuss' => 0);
        $datas['top_list']['item'] = $this->model_I->Interest_List($topic_id);
        $datas['discuss_list']['item'] = $this->model_Dl->Discuss_List($topic_id);
        $datas['topic']['top_num'] = count($datas['top_list']['item']);
        $datas['topic']['discuss'] = count($datas['discuss_list']['item']);
        $datas['my_info'] = array('user_icon' => $this->user_info['user_icon']);
        $this->data($datas);
    }

    /**
     * TODO 帖子活动删除
     * @param $id
     */
    public function forum_del($id)
    {
        $this->model_Fal->destroy(['id' => $id]);
        $this->model_Dl->destroy(['id' => $id, 'type' => 1]);
        $this->model_I->destroy(['id' => $id, 'type' => 1]);
        $this->data(1);
    }

    /**
     * TODO 文章详情页
     * @param int $article_id
     * @param string $key
     */
    public function article_info($article_id = 1, $key = '')
    {
        $token = $this->model_Tk->get(['token' => $key]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
            $result = $this->model_I->get(['art_id' => $article_id, 'type' => 1, 'user_id' => $this->user_info['id']]);
            if (!$result) {
                $this->model_I->save(['art_id' => $article_id, 'type' => 1, 'user_id' => $this->user_info['id']]);
            }
        }
        $Topic = $this->model_Fal->get($article_id);
        $UserInfo = $this->model_Ui->get(['id' => $Topic['m_id']]);
        $img_list = explode(',', $Topic['image']);
        foreach ($img_list as $values) {
            $img_list_arr[]['img'] = $values;
        }
        $datas = array();
        $datas['article'] = array(
            'id' => $article_id,
            'like' => $this->model_Prl->get_praise_state($article_id, 1),
            'user_icon' => $UserInfo['user_icon'],
            'user_name' => $UserInfo['user_name'],
            'last_time' => mdate(to_timespan($Topic['create_time'])),
            'content' => $Topic['content'],
            'img_list' => $img_list_arr,
            'address' => $Topic['address'],
            'top_num' => 0,
            'discuss' => 0);
        $datas['top_list']['item'] = $this->model_I->Interest_List($article_id);
        $datas['discuss_list']['item'] = $this->model_Dl->Discuss_List($article_id);
        $datas['article']['top_num'] = count($datas['top_list']['item']);
        $datas['article']['discuss'] = count($datas['discuss_list']['item']);
        $TagsInfo = $this->model_Ft->get(['id' => $Topic['tags_id']]);
        $datas['article']['tags'] = $TagsInfo['tags_name'];
        $datas['article']['title'] = $Topic['title'];
        $datas['my_info'] = array('user_icon' => $this->user_info['user_icon']);
        $this->data($datas);
    }

    /**
     * TODO 活动详情页
     * @param int $activity_id
     * @param string $key
     */
    public function activity_info($activity_id = 1, $key = '')
    {
        $token = $this->model_Tk->get(['token' => $key]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
            $result = $this->model_I->get(['art_id' => $activity_id, 'type' => 1, 'user_id' => $this->user_info['id']]);
            if (!$result) {
                $this->model_I->save(['art_id' => $activity_id, 'type' => 1, 'user_id' => $this->user_info['id']]);
            }
        }
        $Topic = $this->model_Fal->get($activity_id);
        $UserInfo = $this->model_Ui->get(['id' => $Topic['m_id']]);
        $img_list = explode(',', $Topic['image']);
        foreach ($img_list as $values) {
            $img_list_arr[]['img'] = $values;
        }
        $datas = array();
        $datas['activity'] = array(
            'id' => $activity_id,
            'title' => $Topic['title'],
            'like' => 1,
            'user_name' => $UserInfo['user_name'],
            'user_icon' => $UserInfo['user_icon'],
            'user_tel' => $Topic['user_tel'],
            'start_time' => $Topic['start_time'],
            'end_time' => $Topic['end_time'],
            'address' => $Topic['address'],
            'fish_name' => $Topic['fish_name'],
            'price' => $Topic['price'],
            'content' => $Topic['content'],
            'activity_img' => $Topic['image']);
        $datas['top_list']['item'] = $this->model_I->Interest_List($activity_id);
        $datas['join_list']['item'] = $this->model_Ajl->Join_List($activity_id);;
        $datas['discuss_list']['item'] = $this->model_Dl->Discuss_List($activity_id);
        $datas['my_info'] = array('user_icon' => $this->user_info['user_icon']);
        $this->data($datas);
    }

    /**
     * TODO 活动报名接口
     * @param int $activity_id
     */
    public function get_activity_join($activity_id = 0)
    {
        $this->check_user();
        $poster = input('post.');
        if ($this->model_Fal->filter($poster['message'])) {
            $datas = array();
            $datas['act_id'] = $activity_id;
            $datas['user_id'] = $this->user_info['id'];
            $datas['name'] = $poster['username'] . '(' . $this->user_info['user_name'] . ')';
            $datas['tel'] = $poster['tel'];
            $datas['message'] = $poster['message'];
            $this->model_Ajl->save($datas);
            $datas = array();
            $datas['join_list'] = $this->model_Ajl->Join_List($activity_id);;
            $this->data($datas);
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }

    /**
     * TODO 发布帖子接口
     */
    public function topic_add()
    {
        $this->check_user();
        $poster = input('post.');
        if ($this->model_Fal->filter($poster['message'])) {
            $datas = array();
            $datas['m_id'] = $this->user_info['id'];
            $datas['name'] = $this->user_info['user_name'];
            $datas['ctype'] = $poster['ctype'];
            $datas['atype'] = $poster['atype'];
            $datas['typeid'] = $poster['typeid'];
            $datas['content'] = $poster['message'];
            $datas['image'] = $poster['img_list'];
            $datas['address'] = $poster['address'];
            $this->model_Fal->save($datas);
            $this->data(1);
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }

    /**
     * TODO 发布文章接口
     */
    public function article_add()
    {
        $this->check_user();
        $poster = input('post.');
        if ($this->model_Fal->filter($poster['message'])) {
            $datas = array();
            $datas['m_id'] = $this->user_info['id'];
            $datas['name'] = $this->user_info['user_name'];
            $datas['title'] = $poster['title'];
            $datas['ctype'] = $poster['ctype'];
            $datas['atype'] = $poster['atype'];
            $datas['typeid'] = $poster['typeid'];
            $datas['tags_id'] = $poster['tags_id'];
            $datas['note'] = $poster['note'];
            $datas['content'] = $poster['message'];
            $datas['image'] = $poster['img_list'];
            $this->model_Fal->save($datas);
            $this->data(1);
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }

    /**
     * TODO 发布活动接口
     */
    public function active_add()
    {
        $this->check_user();
        $poster = input('post.');
        if ($this->model_Fal->filter($poster['note'])) {
            $datas = array();
            $datas['m_id'] = $this->user_info['id'];
            $datas['name'] = $this->user_info['user_name'];
            $datas['title'] = $poster['title'];
            $datas['ctype'] = $poster['ctype'];
            $datas['atype'] = $poster['atype'];
            $datas['typeid'] = $poster['typeid'];
            $datas['note'] = $poster['note'];
            if (empty($poster['img'])) {
                $datas['image'] = '/static/images/16-9.jpg';
            } else {
                $datas['image'] = $poster['img'];
            }
            $datas['province'] = $poster['province'];
            $datas['city'] = $poster['city'];
            $datas['county'] = $poster['county'];
            $datas['address'] = $poster['address'];
            $datas['start_time'] = $poster['start_time'];
            $datas['end_time'] = $poster['end_time'];
            $datas['fish_name'] = $poster['fish_name'];
            $datas['price'] = $poster['price'];
            $datas['user_tel'] = $poster['tel'];
            $datas['content'] = $poster['note'];
            $this->model_Fal->save($datas);
            $this->data(1);
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }
}