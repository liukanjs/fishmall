<?php
namespace app\member\controller;

use think\controller\User;

defined('InCnbbx') or exit('Access Invalid!');

class Login extends User
{

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO 会员登录
     */
    public function index()
    {
        $mobile = input('post.mobile');
        $password = input('post.password');
        $result = $this->model_Ui->get(['mobile' => $mobile]);
        if (!empty($result)) {
            if ($result['password'] == md5($password)) {
                $token = md5($mobile . TIMESTAMP);
                $this->model_Tk->save(['linkid' => $mobile, 'token' => $token]);
                $user_info = array();
                if (empty($result['linkid'])) {
                    $wxinfo = unserialize(base64_decode(cookie('wxinfo')));
                    if ($wxinfo) {
                        $user_info['linkid'] = $wxinfo['openid'];
                        if ($result['user_icon'] == '/static/images/noavatar.gif') {
                            curlDownload($wxinfo['headimgurl'], getcwd() . '/static/upload/user/avatar_' . $result['id'] . '.jpg');
                            $user_info['user_icon'] = '/static/upload/user/avatar_' . $result['id'] . '.jpg';
                        }
                    }
                }
                $user_info['login_time'] = TIMESTAMP;
                if (trim(@date('Y-m-d', $result['login_time'])) != trim(date('Y-m-d'))) {
                    $score = $this->model_Con->get('score_login');
                    $experience = $this->model_Con->get('experience_login');
                    $this->model_Ui->User_Score($result['id'], $score['value'], '会员登录赠送' . $score['value'] . '个鱼古！');
                    $this->model_Ui->User_Experience($result['id'], $experience['value'], '会员登录赠送' . $experience['value'] . '个经验！');
                }
                $this->model_Ui->save($user_info, ['mobile' => $mobile]);
                $this->data(['key' => $token]);
            } else {
                $this->error('密码不正确！');
            }
        } else {
            $this->error('手机号未注册！');
        }
    }

    /**
     * TODO 注册接口
     */
    public function register()
    {
        $name = input('post.name');
        $mobile = input('post.mobile');
        $password = input('post.password');
        $password_confirm = input('post.confirm_password');

        if ($this->model_Fal->filter($name)) {
            if ($password == $password_confirm) {
                $captcha = input('post.captcha');
                $result = $this->check_captcha($mobile, $captcha);
                if ($result) {
                    if (input('?post.name')) {
                        $result = $this->model_Ui->save(['user_name' => $name, 'mobile' => $mobile, 'password' => md5($password), 'user_icon' => '/static/images/noavatar.gif']);
                    } else {
                        $result = $this->model_Ui->save(['mobile' => $mobile, 'password' => md5($password), 'user_icon' => '/static/images/noavatar.gif']);
                    }
                    if ($result) {
                        $token = md5($mobile . TIMESTAMP);
                        $this->model_Tk->save(['linkid' => $mobile, 'token' => $token]);
                        $score = $this->model_Con->get('score_reg');
                        $experience = $this->model_Con->get('experience_reg');
                        $this->model_Ui->User_Score($result, $score['value'], '首次登录赠送' . $score['value'] . '个鱼古！');
                        $this->model_Ui->User_Experience($result, $experience['value'], '首次登录赠送' . $experience['value'] . '个经验！');
                        $this->data(['key' => $token]);
                    }
                } else {
                    $this->error('验证码错误！');
                }
            } else {
                $this->error('确认密码不正确！');
            }
        } else {
            $this->error('含有敏感词汇，请修改！');
        }
    }

    /**
     * TODO 退出登录
     */
    public function logout()
    {
        $this->data(1);
    }

    /**
     * TODO 检测手机号
     */
    public function check_mobile()
    {
        $mobile = input('post.mobile');
        $result = $this->model_Ui->get(['mobile' => $mobile]);
        if ($result) {
            echo 'false';
        } else {
            echo 'true';
        }
        die;
    }

    /**
     * TODO 发送验证码
     */
    public function send_captcha()
    {
        $mobile = input('post.mobile');
        $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
        $captcha = random(6, 1);
        $account = 'cf_wmhf2016';
        $password = '5356dfaf79648ed855c6896cda26241c';
        $post_data = "account=" . $account . "&password=" . $password . "&mobile=" . $mobile . "&content=" . rawurlencode("您的验证码是：" . $captcha . "。请不要把验证码泄露给其他人哦。");
        $gets = xml_to_array(Post($post_data, $target));
        $result = $this->model_C->save(['mobile' => $mobile, 'captcha' => $captcha]);
        if ($gets['SubmitResult']['code'] == 2 && $result) {
            echo 'true';
        } else {
            echo 'false';
        }
        die;
    }

    /**
     * TODO 游戏跳转登录
     * @param $token
     * @param $datatime
     * @param $signstr
     * @param int $goods_id
     */
    public function game_login($token, $datatime, $signstr, $goods_id = 0)
    {
        $v_sign = check_md5($token . $datatime, $signstr);
        if ($v_sign) {
            $this->check_api($token);
            $this->model_Tk->save(['linkid' => $this->user_info['mobile'], 'token' => $token]);
            cookie('key', $token);
			$this->integral_query('', $this->user_info['gameid'], TIMESTAMP, 0, true);
            if (empty($goods_id))
                location('/mall/list.html?goods_type=2');
            else
                location('/mall/goods.html?goods_id=' . $goods_id);
        }
        else
        {
            $this->error('参数错误！');
        }
    }

}