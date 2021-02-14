<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Db;
use think\Request;

defined('InCnbbx') or exit('Access Invalid!');

class Member extends Admin
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index($curpage = 1, $page_size = 12, $keyword = '')
    {
        return $this->member_index($curpage, $page_size, $keyword);
    }

    /**
     * TODO 会员列表
     * @param int $curpage
     * @param int $page_size
     * @param string $keyword
     * @return mixed
     */
    public function member_index($curpage = 1, $page_size = 12, $keyword = '')
    {
        $search['keyword'] = $keyword;
        $result = $this->model_Ui->User_List($curpage, $page_size, $search);
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch('member_index');
    }

    /**
     * TODO 会员编辑
     * @param int $id
     * @return mixed
     */
    public function member_edit($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            if (!empty($poster['password'])) {
                $poster['password'] = md5($poster['password']);
            }else{
                $poster['password']= db('user_info')->where('id', $id)->value('password');
            }
            $result = $id ? $this->model_Ui->save($poster, ['id' => $id]) : $this->model_Ui->save($poster);
            if (!empty($result))
                $this->ajax->data(1);
            else
                $this->ajax->error('操作失败，稍后重试！');
        }
        $info = $this->model_Ui->get($id);
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * TODO 会员删除
     * @param int $id
     * @return mixed
     */
    public function member_del($id = 0)
    {
        $result = $this->model_Ui->destroy(['id' => $id]);
        if ($result)
            $this->ajax->data(1);
        else
            $this->ajax->error('操作失败，稍后重试！');
    }


    /**
     * TODO 修改等级经验值
     * @return mixed
     * @throws \Exception
     */
    public function level_index()
    {
        if (chksubmit()) {
            $poster = input('post.');
            $this->model_UL->db()->startTrans();
            $level_array = array();
            foreach ($poster['id'] as $key => $value) {
                $level_array[] = ['id' => $poster['id'][$key], 'level_name' => $poster['level_name'][$key], 'experience' => $poster['experience'][$key]];
            }
            $this->model_UL->saveAll($level_array, true);
            $this->ajax->data(1);
        }
        $result = $this->model_UL->all();
        $this->assign('result', $result);
        return $this->fetch();
    }
}