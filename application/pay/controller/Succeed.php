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
use think\Log;

class Succeed
{
    public function Index ()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $order_info = $data->data->object;
        $order_no = $order_info->order_no;
        $O_info = Db::query("SELECT O_openid,O_increase FROM Pay_Order WHERE O_Id = ?", [$order_no])[0];
        Db::execute('UPDATE Pay_Order SET O_state = 2 WHERE O_Id = ?', [$order_no]);
        Db::execute('UPDATE `User` SET `U_credit` = `U_credit` + ?  WHERE U_openid = ?', [$O_info['O_increase'], $O_info['O_openid']]);
    }
}