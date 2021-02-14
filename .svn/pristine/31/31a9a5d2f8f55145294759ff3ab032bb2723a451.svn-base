<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Jinge <admin@cnbbx.com>
// +----------------------------------------------------------------------
namespace think\controller;
\think\Loader::import('Wechat', TOOLS_PATH, EXT);
\think\Loader::import('Page', TOOLS_PATH, EXT);
use tools\Page;
use think\Request;
use tools\Wechat;
use think\Controller;
use think\controller\Ajax;
use common\model\ForumActivityJoinList as AJL;
use common\model\AddressList as AL;
use common\model\Captcha as C;
use common\model\Config as CON;
use common\model\CartList as CL;
use common\model\DiscussList as DL;
use common\model\FavGoods as FG;
use common\model\ForumArticleList as FAL;
use common\model\ForumNavType as FNT;
use common\model\ForumTags as FT;
use common\model\Interest as I;
use common\model\MallType as MT;
use common\model\MallGoods as MG;
use common\model\PlaceList as PL;
use common\model\Order as O;
use common\model\OrderGoods as OG;
use common\model\Region as R;
use common\model\Recommend as RRL;
use common\model\ScoreLog as SL;
use common\model\Token as TK;
use common\model\UserInfo as UI;
use common\model\UserLevel as UL;
use common\model\PraiseList as PRL;

/**
 * ThinkPHP User控制器类
 */
class Admin extends Controller
{
    protected $user_info;
    protected $model_Ajl;
    protected $model_Al;
    protected $model_C;
    protected $model_Con;
    protected $model_Cl;
    protected $model_Fg;
    protected $model_Ft;
    protected $model_Fnt;
    protected $model_Fal;
    protected $model_Dl;
    protected $model_I;
    protected $model_Mt;
    protected $model_Mg;
    protected $model_Pl;
    protected $model_Prl;
    protected $model_O;
    protected $model_Og;
    protected $model_R;
    protected $model_Rrl;
    protected $model_Sl;
    protected $model_Tk;
    protected $model_Ui;
    protected $model_UL;
    protected $ajax;
    protected $page;
    // 微信调用类
    protected $wechat;

    /**
     * 架构函数
     * @param Request $request
     * @param bool $isadmin
     */
    public function __construct(Request $request, $isadmin = true)
    {
        parent::__construct($request);
        $this->ajax = new Ajax;
        $this->model_Ajl = new AJL;
        $this->model_Al = new AL;
        $this->model_C = new C;
        $this->model_Con = new CON;
        $this->model_Cl = new CL;
        $this->model_Fg = new FG;
        $this->model_Ft = new FT;
        $this->model_Fnt = new FNT;
        $this->model_Fal = new FAL;
        $this->model_Dl = new DL;
        $this->model_I = new I;
        $this->model_Mt = new MT;
        $this->model_Mg = new MG;
        $this->model_Pl = new PL;
        $this->model_Prl = new PRL;
        $this->model_O = new O;
        $this->model_Og = new OG;
        $this->model_R = new R;
        $this->model_Rrl = new RRL;
        $this->model_Sl = new SL;
        $this->model_Tk = new TK;
        $this->model_Ui = new UI;
        $this->model_UL = new UL;
        $this->page = new Page;
        // 微信类初始化
        $this->wechat = new Wechat(['token' => 'cnbbx', 'pem' => 'wechat', 'appid' => 'wxca1d9e03c5cde04a', 'secret' => 'e80e6ba910d8f37dc8ccc6d80eab4197', 'mchid' => '1329223001', 'mkey' => 'e10adc3949ba59abbe56e057f20f883e']);

        // 检测管理员登录
        $this->check_admin($isadmin);
    }

    /**
     * 检测管理员登录
     * @param bool $isadmin
     */
    public function check_admin($isadmin = true)
    {
        $admin = session('isadmin');
        if ($isadmin) {
            if (!$admin) {
                location('/admin/index/index/login');
            }
        } else {
            if (!$admin) {
                $mobile = input('post.mobile');
                $password = input('post.password');
                if ($mobile != '' && $password != "") {
                    $login = $this->model_Ui->get(['mobile' => $mobile, 'password' => md5($password)]);
                    if ($login) {
                        if ($login['admin']) {
                            session('isadmin', $login);
                            location('/admin/');
                        } else {
                            $this->error('非管理员权限!');
                        }
                    } else {
                        $this->error('账户或密码错误!');
                    }
                }
            }
        }
        $this->user_info = $admin;
        $this->assign('user_info', $admin);
    }

    /**
     * TODO 通知APP已经发货
     * @param string $orderid
     * @param string $gameid
     * @param int $score
     * @param string $datatime
     * @return mixed
     * @throws \think\Exception
     */
    public function order_send_query($orderid = '', $gameid = '', $score = 0, $datatime = '')
    {
        $post_data = array(
            'orderid' => $orderid,
            'gameid' => $gameid,
            'score' => $score,
            'datatime' => $datatime,
            'signstr' => md5($orderid . $gameid . $score . $datatime . '51kydy')
        );
        $posts = json_decode(Post($post_data, 'http://115.159.33.95:8080/notify'));
        if ($posts->code == 1) {
            return 1;
        } else {
            return 0;
        }
    }
}
