<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/5/29
 * Time: 上午12:18
 */

namespace app\pay\controller;

use think\Db;
use think\Debug;

class Succeed
{
    public function Index ()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $order_info = $data->data->object;
        $order_no = $order_info->order_no;
        $amount = $order_info->amount / 100;
        $level = json_decode(Server_Setting('level'), true);
        $price = json_decode(Server_Setting('price'), true);
        $credit = 0;
        echo $amount."\r\n";
        foreach ($price as $key => $val) {
            if ($val - $amount >= 0) {
                if ($val - $amount == 0) {
                    $credit = $price[0];
                }
                else {
                    if ($amount < $price[0]) {
                        $credit = 0;
                    } else {
                        $credit = $level[$key - 1];
                    }
                }
            }
        }
        if ($amount > $price[count($price) - 1]){
            $credit = $level[count($level) - 1];
        }
        echo $credit;
        $O_openid = Db::query("SELECT O_openid FROM Pay_Order WHERE O_Id = ?", [$order_no])[0]['O_openid'];
        Db::execute('UPDATE Pay_Order SET O_state = 2 WHERE O_Id = ?', [$order_no]);
        Db::execute('UPDATE `User` SET `U_credit` = `U_credit` + ?  WHERE U_openid = ?', [$credit, $O_openid]);
    }
}