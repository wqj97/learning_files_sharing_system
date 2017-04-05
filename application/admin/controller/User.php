<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/5
 * Time: 上午1:50
 */

namespace app\admin\controller;


use think\Db;

class User
{
    /**
     * 查询用户信息
     * @get user_id
     * @return \think\response\Json
     */
    public function Index()
    {
        $user_id = input('get.user_id');
        $user_info = Db::query("SELECT U_name,U_school,U_credit FROM User WHERE U_Id = ?", [$user_id])[0];
        return json($user_info);
    }

    /**
     * 修改用户信息
     * @post user_id
     * @post user_name
     * @post user_credit
     * @post user_school
     * @return \think\response\Json
     */
    public function Save()
    {
        $user_id = input("post.user_id");
        $user_name = input("post.user_name");
        $user_creadit = input("post.user_credit");
        $user_school = input("post.user_school");
        Db::execute("UPDATE User SET U_name = ?,U_credit = ?, U_school = ? WHERE U_Id = ?", [$user_name, $user_creadit, $user_school, $user_id]);
        return json(["result" => "success"]);
    }
}