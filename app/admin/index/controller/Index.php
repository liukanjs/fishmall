<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Request;
use think\Image;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends Admin
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request, false);
    }

    public function index()
    {
        $this->check_admin();
        return $this->fetch();
    }

    public function register()
    {
        return $this->fetch();
    }

    public function auto_file()
    {
        set_time_limit(0);
        $list = listDir('../public/static/upload');
        foreach ($list as $value) {
            try {
                $image = Image::open($value);
                $image->thumb(800, 800, Image::THUMB_SCALING);
                $image->save($value);
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
    }

    public function login()
    {
        session('isadmin', null);
        return $this->fetch();
    }

    public function main()
    {
        $this->check_admin();
        $total_rmb_price = $this->model_O->db()->whereTime('create_time', 'month')->where('order_state', 'gt', 10)->sum('total_rmb_price');
        $total_order_num = $this->model_O->db()->whereTime('create_time', 'month')->where('order_state', 'gt', 10)->count();
        $total_member_num = $this->model_Ui->db()->whereTime('create_time', 'month')->count();
        $total_thread_num = $this->model_Fal->db()->whereTime('create_time', 'month')->where('atype', 'eq', 1)->count();
        $total_goods_list = $this->model_Og->db()->whereTime('create_time', 'month')->field('`goods_id`, `title`, SUM(`goods_num`) AS goods_num, SUM(`rmb_price`) AS rmb_price')->order('rmb_price desc')->group('goods_id')->select();
        $total_user_list = $this->model_O->db()->whereTime('b.create_time', 'month')->alias('a')->join('user_info b', 'a.user_id = b.id')->field('b.user_name,b.level,SUM(a.total_rmb_price) as total_rmb_price,SUM(a.total_score_price) as total_score_price')->order('a.total_rmb_price desc')->group('a.user_id')->select();
        $total = array();
        $total['total_rmb_price'] = $total_rmb_price;
        $total['total_order_num'] = $total_order_num;
        $total['total_member_num'] = $total_member_num;
        $total['total_thread_num'] = $total_thread_num;
        $total['total_goods_list'] = $total_goods_list;
        $total['total_user_list'] = $total_user_list;
        $firstday = date("Y-m-01", TIMESTAMP);
        $lastday = date("Y-m-d", strtotime("$firstday +1 month -1 day"));
        $c = 0;
        for ($i = $firstday; $i <= $lastday; $i++) {
            $dates = date("Y-m-d", strtotime("$firstday +$c day"));
            $total['month'][] = $dates;
            $total['order_num'][] = $this->model_O->db()->where('create_time', 'between time', [$dates . ' 00:00:00', $dates . ' 23:59:59'])->where('order_state', 'gt', 10)->count();
            $total['pay_price'][] = $this->model_O->db()->where('create_time', 'between time', [$dates . ' 00:00:00', $dates . ' 23:59:59'])->where('order_state', 'gt', 10)->sum('total_rmb_price');
            $c++;
        }
        $this->assign('total', $total);
        return $this->fetch();
    }
}