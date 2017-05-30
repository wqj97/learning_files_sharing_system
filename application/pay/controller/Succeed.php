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
        $amount = $order_info->amount;
        $level = json_decode(Server_Setting('level'),true);
        $price = json_decode(Server_Setting('price'),true);
        $credit = 0;
        foreach ($price as $key => $val) {
            if ($val == $amount) {
                $credit = $level[$key +1];
            }
        }
        $O_openid = Db::query("select O_openid from Pay_Order where O_Id = ?",[$order_no])[0]['O_openid'];
        Db::execute('update Pay_Order set O_state = 2 where O_Id = ?',[$order_no]);
        Db::execute('update `User` set `U_credit` = `U_credit` + ?  where U_openid = ?',[$credit,$O_openid]);
    }
}