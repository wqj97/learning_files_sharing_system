<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/14
 * Time: 上午11:16
 */

namespace app\pay\controller;

require_once $_SERVER['DOCUMENT_ROOT'] . "/extend/pingxx/vendor/autoload.php";

use Pingpp\Pingpp;
use Pingpp\Charge;
use think\Db;

class Index
{
    public function Index ()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        $price = input('post.amount', 100);
        $openid = cookie('openid');
        Db::execute('INSERT INTO Pay_Order (O_openid,O_total_fee,O_state) VALUE (?,?,?)', [$openid, $price, 0]);
        $order_no = Db::query('select last_insert_id() as Id')[0]['Id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $pingpp = new Pingpp();
//        $pingpp::setApiKey('sk_test_5aDyr9rjvnP0i9Sir9afD0OS');
        Pingpp::setApiKey('sk_live_8iPajPzbHCaLnDyPi5D88WrP');
        $pingpp::setPrivateKeyPath($_SERVER['DOCUMENT_ROOT'] . "/extend/pingxx/pem/private.key");
        return Charge::create(array(
                'order_no' => $order_no,
                'amount' => $price,  //订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                'app' => array('id' => 'app_HOyvHKPCajnHCarT'),
                'channel' => 'wx_pub',
                'currency' => 'cny',
                'client_ip' => $ip,
//                'extra' => [
//                    'success_url' => 'https://www.aiyouyi.net.cn/home/#/buy?success',
//                    'cancel_url' => 'https://www.aiyouyi.net.cn/home/#/buy?cancel'
//                ],
                'subject' => "爱优医" . $price / 100 . "元赞助",
                'body' => '赞助爱优医')
        );
    }
}