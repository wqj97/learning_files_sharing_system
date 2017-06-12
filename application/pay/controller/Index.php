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

        $credit_and_price = $this->geneticCredit($price, $openid);

        Db::execute('INSERT INTO Pay_Order (O_openid,O_total_fee,O_state, O_increase) VALUE (?,?,?,?)', [$openid,
            $price, 0, $credit_and_price[1]]);
        $order_no = Db::query('select last_insert_id() as Id')[0]['Id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $pingpp = new Pingpp();
//        $pingpp::setApiKey('sk_test_5aDyr9rjvnP0i9Sir9afD0OS');
        Pingpp::setApiKey('sk_live_8iPajPzbHCaLnDyPi5D88WrP');
        $pingpp::setPrivateKeyPath($_SERVER['DOCUMENT_ROOT'] . "/extend/pingxx/pem/private.key");
        return Charge::create(array(
                'order_no' => $order_no,
                'amount' => $credit_and_price[0],  //订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                'app' => array('id' => 'app_HOyvHKPCajnHCarT'),
                'channel' => 'wx_pub',
                'currency' => 'cny',
                'client_ip' => $ip,
                'extra' => [
                    'open_id' => "$openid",
                ],
                'subject' => "爱优医" . $credit_and_price[1] / 100 . "元赞助",
                'body' => '赞助爱优医',
                'description' => "减免后价格: {$credit_and_price[0]}, 增加分数: {$credit_and_price[1]}, 当前用户等级: {$credit_and_price[2]}"
            )
        );
    }

    /**
     * 订单增加分数计算
     * @param $price
     * @param $openid
     * @return array
     */
    private function geneticCredit ($price, $openid)
    {

        $amount = $price / 100;
        $user_credit = Db::query("SELECT U_credit FROM User WHERE U_openid = ?", [$openid])[0]['U_credit'];
        $user_level = getLevel($user_credit);
        $level = json_decode(Server_Setting('level'), true);
        $price = json_decode(Server_Setting('price'), true);

        # 计算加分数
        $credit = 0;
        # 增加 目标等级 - 当前等级 的分数
        foreach ($price as $key => $val) {
            if ($val - $amount >= 0) {
                $credit = $level[$key + 1] - $level[$user_level];
                break;
            }
        }
        # 如果 金额大于最高等级金额, 直接获得最多分数
        if ($amount > $price[count($price) - 1]) {
            $credit = $level[count($level) - 1];
        }
        # 如果 金额最低等级还小, 不获得分数
        if ($amount < $price[0]) {
            $credit = 0;
        }

        // 计算需要多少钱
        if ($user_level != 0) {
            $amount -= $price[$user_level -1];
        }
        if ($amount < 0) {
            $amount = 0;
        }
        if ($credit < 0) {
            $credit = 0;
        }
        return [$amount * 100, $credit, $user_level];
    }
}