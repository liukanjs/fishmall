<?php
namespace app\app\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Index extends User
{
    /**
     * TODO 架构函数
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO 通信检测
     *
     * @param int $linkid
     */
    public function index($linkid = 1)
    {
        $this->data($linkid);
    }


    /**
     * TODO 检测手机号
     * @param int $mobile
     */
    public function check_mobile($mobile = 0)
    {
        $result = $this->model_Ui->get(['mobile' => $mobile]);
        if (!empty($result)) {
            if (empty($result['gameid'])) {
                $this->data(2);
            } else {
                $this->data(3);
            }
        } else {
            $this->data(1);
        }
    }

    /**
     * TODO 注册/绑定社区帐号
     * @param int $gameid
     * @param int $datatime
     * @param string $mobile
     * @param string $password
     * @param string $signstr
     */
    public function bind_reg($gameid = 0, $datatime = 0, $mobile = '', $password = '', $signstr = '')
    {
        $v_sign = check_md5($gameid . $datatime, $signstr);
        if ($v_sign) {
            $result = $this->model_Ui->get(['mobile' => $mobile]);
            $results = $this->check_captcha($mobile, $password);
            if (!empty($result)) {
                // 历史短信验证码登陆
                if ($result['password'] == md5($password) || $results) {
                    $token = md5($mobile . TIMESTAMP);
                    $this->model_Ui->save(['token' => $token, 'gameid' => $gameid], ['mobile' => $mobile]);
                    $this->data(array('token' => $token));
                } else {
                    $this->error('密码不正确！');
                }
            } else {
                // 新会员注册
                if ($results) {
                    $token = md5($mobile . TIMESTAMP);
                    $this->model_Ui->save(['mobile' => $mobile, 'password' => md5($password), 'user_icon' => '/static/images/noavatar.gif', 'gameid' => $gameid, 'token' => $token]);
                    $this->data(array('token' => $token));
                } else {
                    $this->error('验证码不正确！');
                }
            }
        } else {
            $this->error('非法请求！');
        }
    }

    /**
     * TODO 同步鱼古值
     *
     * @param int|string $token
     * @param int|string $orderid
     * @param int|string $gameid
     * @param int|string $datatime
     * @param int $score
     * @param string $log
     * @param string $signstr
     * @throws \think\Exception
     * @internal param int $linkid
     */
    public function sync_point($token = '', $orderid = '', $gameid = '', $datatime = '', $score = 1, $log = '', $signstr = '')
    {
        $v_sign = check_md5($orderid . $gameid . $score . $datatime, $signstr);
        if ($v_sign) {
            $this->check_api($token);
            if (!empty($this->user_info)) {
                $this->model_Ui->where(['id' => $this->user_info['id']])->setInc('score', $score);
                $this->model_Sl->save(['user_id' => $this->user_info['id'], 'score' => $score, 'note' => $log]);
                $this->data(1);
            }
        } else {
            $this->error('非法请求！');
        }
    }

    /**
     * TODO 发送验证码
     * @param int $send_type
     * @param int $mobile
     */
    public function send_captcha($send_type = 0, $mobile = 0)
    {
        $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
        $captcha = random(6, 1);
        $account = 'cf_wmhf2016';
        $password = '5356dfaf79648ed855c6896cda26241c';
        if ($send_type == 1) {
            $post_data = rawurlencode("您的验证码是：" . $captcha . "。输入验证码验证手机就可以去兑换实物产品啦；请不要把验证码泄露给其他人,同时该验证码也是您的初始密码哦！");
        } else if ($send_type == 2) {
            $post_data = rawurlencode("您的验证码是：" . $captcha . "。输入验证码验证手机就可以去兑换实物产品啦；请不要把验证码泄露给其他人哦！");
        } else {
            $post_data = rawurlencode("您的验证码是：" . $captcha . "。请不要把验证码泄露给其他人哦。");
        }
        $gets = xml_to_array(Post("account=" . $account . "&password=" . $password . "&mobile=" . $mobile . "&content=" . $post_data, $target));
        $result = $this->model_C->save(['mobile' => $mobile, 'captcha' => $captcha]);
        if ($gets['SubmitResult']['code'] == 2 && $result) {
            $this->data(1);
        } else {
            $this->error('获取短信错误');
        }
    }
}