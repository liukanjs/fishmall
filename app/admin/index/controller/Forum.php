<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Request;

defined('InCnbbx') or exit('Access Invalid!');

class Forum extends Admin
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * TODO 帖子首页
     * @param int $typeid
     * @param int $ctype
     * @param int $atype
     * @param int $curpage
     * @param int $page_size
     * @return mixed
     */
    public function index($typeid = 0, $ctype = 0, $atype = 1, $curpage = 1, $page_size = 12)
    {
        return $this->thread_index($typeid, $ctype, $atype, $curpage, $page_size);
    }

    /**
     * TODO 帖子列表
     * @param int $typeid
     * @param int $ctype
     * @param int $atype
     * @param int $curpage
     * @param int $page_size
     * @return mixed
     * @internal param int $curpage
     */
    public function thread_index($typeid = 0, $ctype = 0, $atype = 1, $curpage = 1, $page_size = 12)
    {
        $result = $this->model_Fal->getArticleList($typeid, $ctype, $atype, $curpage, $page_size, input('get.'));
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch('thread_index');
    }

    /**
     * TODO 帖子详情
     *
     * @param $id
     * @return mixed
     */
    public function thread_detail($id)
    {
        $info = $this->model_Fal->get($id);
        if (!empty($info)) {
            $info['images_list'] = explode(',', $info['image']);
            $info['user_info'] = $this->model_Ui->get($info['m_id']);
            $info['top_list'] = $this->model_I->Interest_List($id);
            $info['discuss_list'] = $this->model_Dl->Discuss_List($id);
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 编辑和新增帖子
     *
     * @param int $id
     * @return mixed
     */
    public function thread_add($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            if (empty($id)) {
                $poster['m_id'] = $this->user_info['id'];
                $poster['name'] = $this->user_info['user_name'];
            }
            $result = $id ? $this->model_Fal->save($poster, ['id' => $id]) : $this->model_Fal->save($poster);
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Fal->get($id);
        if (!empty($info)) {
            $info['images_list'] = explode(',', $info['image']);
            $info['user_info'] = $this->model_Ui->get($info['m_id']);
            $info['top_list'] = $this->model_I->Interest_List($id);
            $info['discuss_list'] = $this->model_Dl->Discuss_List($id);
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 删除帖子
     *
     * @param int $id
     */
    public function thread_del($id = 0)
    {
        $result = $this->model_Fal->destroy(['id' => $id]);
        $this->model_Dl->destroy(['type' => 1, 'art_id' => $id]);
        $this->model_I->destroy(['type' => 1, 'art_id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 帖子置顶
     * @param int $id
     */
    public function thread_top($id = 0)
    {
        $istop = $this->model_Fal->get(['istop' => 1, 'id' => $id]);
        if ($istop) {
            $result = $this->model_Fal->save(['istop' => 0], ['id' => $id]);
            $this->ajax->data(2);
        } else {
            $result = $this->model_Fal->save(['istop' => 1], ['id' => $id]);
            $this->ajax->data(1);
        }
        if (!$result) $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * 推荐到微信首页
     *
     * @param int $id
     */
    public function to_index($id = 0)
    {
        $istop = $this->model_Fal->get(['ishome' => 1, 'id' => $id]);
        if ($istop) {
            $result = $this->model_Fal->save(['ishome' => 0], ['id' => $id]);
            $this->ajax->data(2);
        } else {
            $result = $this->model_Fal->save(['ishome' => 1], ['id' => $id]);
            $this->ajax->data(1);
        }
        if (!$result) $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 删除评论
     *
     * @param int $id
     */
    public function discuss_del($id = 0)
    {
        $result = $this->model_Dl->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 板块查询
     *
     * @return mixed
     */
    public function board_index()
    {
        $list = $this->model_Fnt->all();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * TODO 板块编辑和新增
     *
     * @param int $id
     * @return mixed
     */
    public function board_edit($id = 0)
    {
        if (chksubmit()) {
            $result = $id ? $this->model_Fnt->save(input('post.'), ['id' => $id]) : $this->model_Fnt->save(input('post.'));
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Fnt->get($id);
        if (!empty($info))
            $this->assign('info', $info->toJson());
        else
            $this->assign('info', '');
        $ctype = new \ctype;
        $atype = new \atype;
        $this->assign('ctype_list', $ctype->get_items());
        $this->assign('atype_list', $atype->get_items());
        return $this->fetch();
    }

    /**
     * TODO 板块删除
     *
     * @param int $id
     */
    public function board_del($id = 0)
    {
        $result = $this->model_Fnt->destroy(['id' => $id]);
        $this->model_Dl->destroy(['type' => 1, 'art_id' => $id]);
        $this->model_I->destroy(['type' => 1, 'art_id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 活动列表
     *
     * @param int $typeid
     * @param int $ctype
     * @param int $atype
     * @param int $curpage
     * @param int $page_size
     * @return mixed
     */
    public function active_index($typeid = 0, $ctype = 0, $atype = 3, $curpage = 1, $page_size = 12)
    {
        $result = $this->model_Fal->getArticleList($typeid, $ctype, $atype, $curpage, $page_size, input('get.'));
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch();
    }

    /**
     * TODO 活动编辑
     *
     * @param int $id
     * @return mixed
     */
    public function active_edit($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            if (empty($id)) {
                $poster['m_id'] = $this->user_info['id'];
                $poster['name'] = $this->user_info['user_name'];
            }
            $result = $id ? $this->model_Fal->save($poster, ['id' => $id]) : $this->model_Fal->save($poster);
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Fal->get($id);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 删除活动
     *
     * @param int $id
     */
    public function active_del($id = 0)
    {
        $result = $this->model_Fal->destroy(['id' => $id]);
        $this->model_Dl->destroy(['type' => 1, 'art_id' => $id]);
        $this->model_I->destroy(['type' => 1, 'art_id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    public function active_detail($id = 0)
    {
        $info = $this->model_Fal->get($id);
        if (!empty($info)) {
            $info['images_list'] = explode(',', $info['image']);
            $info['user_info'] = $this->model_Ui->get($info['m_id']);
            $info['top_list'] = $this->model_I->Interest_List($id);
            $info['discuss_list'] = $this->model_Dl->Discuss_List($id);
            $info['join_list'] = $this->model_Ajl->Join_List($id);;
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 文章管理
     *
     * @param int $typeid
     * @param int $ctype
     * @param int $atype
     * @param int $curpage
     * @param int $page_size
     * @return mixed
     */
    public function article_index($typeid = 0, $ctype = 0, $atype = 2, $curpage = 1, $page_size = 12)
    {
        $result = $this->model_Fal->getArticleList($typeid, $ctype, $atype, $curpage, $page_size, input('get.'));
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch();
    }

    /**
     * TODO 文章详情
     *
     * @param $id
     * @return mixed
     */
    public function article_detail($id)
    {
        $info = $this->model_Fal->get($id);
        if (!empty($info)) {
            $info['images_list'] = explode(',', $info['image']);
            $info['user_info'] = $this->model_Ui->get($info['m_id']);
            $info['top_list'] = $this->model_I->Interest_List($id);
            $info['discuss_list'] = $this->model_Dl->Discuss_List($id);
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 编辑和新增文章
     *
     * @param int $id
     * @return mixed
     */
    public function article_add($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            if (empty($id)) {
                $poster['m_id'] = $this->user_info['id'];
                $poster['name'] = $this->user_info['user_name'];
            }
            $result = $id ? $this->model_Fal->save($poster, ['id' => $id]) : $this->model_Fal->save($poster);
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Fal->get($id);
        if (!empty($info)) {
            $info['images_list'] = explode(',', $info['image']);
            $info['userinfo'] = $this->model_Ui->get($info['m_id']);
            $info['top_list'] = $this->model_I->Interest_List($id);
            $info['discuss_list'] = $this->model_Dl->Discuss_List($id);
        }
        $ctype = new \ctype;
        $atype = new \atype;
        $this->assign('ctype_list', $ctype->get_items());
        $this->assign('atype_list', $atype->get_items());
        $this->assign('type', ['fnt' => $this->model_Fnt->all(['atype' => 2, 'id' => ['neq', 2]]), 'tags' => $this->model_Ft->all()]);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 删除文章
     *
     * @param int $id
     */
    public function article_del($id = 0)
    {
        $result = $this->model_Fal->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    /**
     * TODO 文章置顶
     * @param int $id
     */
    public function article_top($id = 0)
    {
        $istop = $this->model_Fal->get(['istop' => 1, 'id' => $id]);
        if ($istop) {
            $result = $this->model_Fal->save(['istop' => 0], ['id' => $id]);
            $this->ajax->data(2);
        } else {
            $result = $this->model_Fal->save(['istop' => 1], ['id' => $id]);
            $this->ajax->data(1);
        }
        if (!$result) $this->ajax->error('操作失败，稍后重试！');
    }


    public function tags_index($id = 0)
    {
        if (chksubmit()) {
            $result = $id ? $this->model_Ft->save(input('post.'), ['id' => $id]) : $this->model_Ft->save(input('post.'));
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Ft->get($id);
        $this->assign('info', $info);
        $type = $this->model_Fnt->all(['atype' => 2, 'id' => ['neq', 2]]);
        $this->assign('type', $type);
        $list = $this->model_Ft->db()->field('a.*,t.name')->alias('a')->join('forum_nav_type t', 'a.typeid = t.id')->order('a.id desc')->select();
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function tags_del($id = 0)
    {
        $result = $this->model_Ft->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }

    public function set_index()
    {
        return $this->fetch();
    }
}