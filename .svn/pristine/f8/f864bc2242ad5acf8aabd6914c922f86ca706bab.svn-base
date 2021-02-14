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
use tools\Wechat;
use common\model\ForumActivityJoinList as AJL;
use common\model\AddressList as AL;
use common\model\Captcha as C;
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
use common\model\PraiseList as PRL;
use common\model\Config as CON;


/**
 * ThinkPHP User控制器类
 */
class User extends Ajax
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
    // 微信调用类
    protected $wechat;

    /**
     * 架构函数
     */
    public function __construct()
    {
        parent::__construct();
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
        // 微信类初始化
        $this->wechat = new Wechat(['token' => 'cnbbx', 'pem' => 'wechat', 'appid' => 'wxca1d9e03c5cde04a', 'secret' => 'e80e6ba910d8f37dc8ccc6d80eab4197', 'mchid' => '1329223001', 'mkey' => 'e10adc3949ba59abbe56e057f20f883e']);
    }

    /**
     * TODO 检测会员登录
     */
    public function check_user()
    {
        $token = $this->model_Tk->get(['token' => input('post.key')]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['linkid']]);
        } else {
            $this->error('请先登陆后重试！');
        }
    }

    /**
     * TODO 检测验证码
     */
    public function check_captcha($mobile, $captcha)
    {
        $result = $this->model_C->get(['mobile' => $mobile, 'captcha' => $captcha]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检测token
     * @param $token
     */
    public function check_api($token)
    {
        $token = $this->model_Ui->get(['token' => $token]);
        if ($token) {
            $this->user_info = $this->model_Ui->get(['mobile' => $token['mobile']]);
        } else {
            $this->error('非法请求！');
        }
    }

    /**
     * TODO APP鱼古操作
     * @param string $orderid
     * @param string $gameid
     * @param string $datatime
     * @param int $score
     * @param bool $sync
     * @return mixed
     * @throws \think\Exception
     */
    public function integral_query($orderid = '', $gameid = '', $datatime = '', $score = 0, $sync = false)
    {
        $post_data = array(
            'orderid' => $orderid,
            'gameid' => $gameid,
            'score' => $score,
            'datatime' => $datatime,
            'signstr' => md5($orderid . $gameid . $score . $datatime . '51kydy')
        );
        $posts = json_decode(Post($post_data, 'http://115.159.33.95:8080/syncpoint'));
        if ($posts->code == 1) {
            $score = $posts->datas->score;
            //同步鱼古
            if ($sync) $this->model_Ui->where(['id' => $this->user_info['id']])->update(['score' => $score]);
            return true;
        } else {
            return false;
        }
    }
}
