<?php
namespace app\index\controller;

use think\Controller;
use common\model\Order as O;
use common\model\ScoreLog as SL;
use common\model\Token as TK;
use common\model\UserInfo as UI;

defined('InCnbbx') or exit('Access Invalid!');

class Wechatapi extends Controller
{
    /**
     * TODO 微信端综合首页
     */
    public function index()
    {
        cookie('ref_url', input('get.ref_url'));
        location($this->wechat->getOAuthRedirect('http://' . $_SERVER['HTTP_HOST'] . '/api/index/WechatApi/wxcallback', 'wechat', 'snsapi_userinfo'));
    }

    /**
     * TODO 微信登录接口回调
     */
    public function wxcallback()
    {
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        $AccessToken = $this->wechat->getOauthAccessToken();
        $UserInfo = $this->wechat->getOauthUserInfo($AccessToken['access_token'], $AccessToken['openid']);
        $UserInfo['nickname'] = preg_replace('/([\x{19999}-\x{9fa5A}])/u', '', $UserInfo['nickname']);
        $model_Ui = new UI;
        $result = $model_Ui->get(['linkid' => $UserInfo['openid']]);
        if ($result) {
            $token = md5($result['mobile'] . TIMESTAMP);
            $model_Tk = new TK;
            $model_Tk->save(['linkid' => $result['mobile'], 'token' => $token]);
            if ($result['user_icon'] == '/static/images/noavatar.gif') {
                curlDownload($UserInfo['headimgurl'], getcwd() . '/static/upload/user/avatar_' . $result['id'] . '.jpg');
                $model_Ui->save(['user_icon' => '/static/upload/user/avatar_' . $result['id'] . '.jpg'], ['mobile' => $result['mobile']]);
            }
            cookie('key', $token);
        }
        cookie('username', $UserInfo['nickname']);
        cookie('wxinfo', base64_encode(serialize($UserInfo)));
        location(cookie('ref_url'));
    }

    /**
     * TODO 微信js接口
     */
    public function jsapi()
    {
        $this->wechat->getToken();
        $url = $_GET['url'];
        if (!empty($url)) {
            $url = str_replace('&amp;', '&', $url);
        }
        $wx = $this->wechat->getSignPackage($url);
        $wx["jsApiList"] = array('chooseWXPay', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'hideOptionMenu', 'showOptionMenu', 'closeWindow', 'scanQRCode');
        $content = "";
        $content .= "wx.config(" . json_encode($wx) . ");";
        echo $content;
        exit;
    }

    /**
     * TODO 扫描支付
     */
    public function native()
    {
        $this->error('扫描支付！');
    }

    /**
     * TODO 微信支付通知
     */
    public function notify_fish()
    {
        header("Content-type: text/xml");
        $model_O = new O;
        $model_Sl = new SL;
        $model_Ui = new UI;
        $datas = $this->wechat->request();
        $out_trade_no = $datas['out_trade_no'];
        $transaction_id = $datas['transaction_id'];
        $total_fee = $datas['total_fee'] / 100;
        $result_ok = $model_O->get(['order_state' => 20, 'order_sn' => $out_trade_no]);
        if ($result_ok) {
            $this->wechat->returnNotify(true);
        } else {
            $order_info = $model_O->get(['order_sn' => $out_trade_no]);
            $user_info = $model_Ui->get(['id' => $order_info['user_id']]);
            $is_ok = $this->integral_query($out_trade_no, $user_info['gameid'], TIMESTAMP, $order_info['total_score_price'] * -1);
            if ($is_ok || $order_info['total_score_price'] == 0) {
                $result = $model_O->save(['order_state' => 20, 'pay_sn' => $transaction_id, 'pay_time' => TIMESTAMP], ['order_sn' => $out_trade_no]);
                if ($result) {
                    if ($order_info) {
                        $score = $this->model_Con->get('score_buy');
                        $experience = $this->model_Con->get('experience_buy');
                        $this->model_Ui->User_Score($order_info['user_id'], $score['value'] * $total_fee, '会员购物赠送' . ($score['value'] * $total_fee) . '个鱼古！');
                        $this->model_Ui->User_Experience($order_info['user_id'], $experience['value'] * $total_fee, '会员购物赠送' . ($experience['value'] * $total_fee) . '个经验！');
                        $model_Ui->save(['score' => ($user_info['score'] - $order_info['total_score_price'])], ['id' => $order_info['user_id']]);
                        $model_Sl->save(['user_id' => $order_info['user_id'], 'score' => ($order_info['total_score_price'] * -1), 'note' => '购物订单：' . $order_info['order_sn'] . '，消费使用' . $order_info['total_score_price'] . '鱼古']);
                    }
                    $this->wechat->returnNotify(true);
                } else {
                    $this->wechat->returnNotify(false);
                }
            } else {
                $this->wechat->returnNotify(false);
            }
        }
    }

}