<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Model;
use think\Request;
use think\Cache;

defined('InCnbbx') or exit('Access Invalid!');

class System extends Admin
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function wechat_index()
    {
        return $this->fetch();
    }

    public function pay_index()
    {
        return $this->fetch();
    }

    public function score_index()
    {
        if (chksubmit()) {
            $poster = input('post.');
            $datas = array();
            foreach ($poster as $key => $value) {
                $data = array();
                $data['name'] = $key;
                $data['value'] = $value;
                $datas[] = $data;
            }
            model('config')->saveAll($datas, true);
            $this->ajax->data(1);
        }
        $this->assign('info', model('config')->column('name,value'));
        return $this->fetch();
    }

    public function cache_index()
    {
        return view();
    }

    public function cache_del()
    {
        if (request()->isGet()) {
            Cache::clear();
            $this->ajax->data(1);
        }
    }

    /**
     * TODO 管理员列表
     */
    public function admin_index()
    {
        $data = db('user_info')->where('admin', 1)->select();
        $this->assign('info', $data);
        return $this->fetch();
    }

    /**
     * TODO 删除管理员权限
     * @param int $id
     */
    public function admin_del($id = 0)
    {
        $data = db('user_info')->where('id', $id)->setField('admin', 0);
        if ($data) {
            $this->ajax->data(1);
        } else {
            $this->ajax->error('操作失败，稍后重试！');
        }
    }

}