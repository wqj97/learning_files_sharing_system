<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/29
 * Time: 下午7:53
 */

namespace app\user\controller;


use think\Db;

class School
{
    /**
     * 获取所有学校的键值对
     * @return \think\response\Json
     */
    public function List()
    {
        $school_list = Db::query("select S_Id as Id, S_name as name, S_city as city from School");
        return json($school_list);
    }


    /**
     * 查询所有城市
     * @get String city (Optional)
     * @return \think\response\Json
     */
    public function City()
    {
        $city = input('get.city','');
        $province_list = Db::query("select S_city from School where S_city like ? GROUP BY S_city ORDER BY S_Id",["%$city%"]);
        return json($province_list);
    }

    /**
     * 查询城市下的学校
     * @get String city
     * @return \think\response\Json
     */
    public function Index()
    {
        $city = input('get.city');
        $school = Db::query("select * from School where S_city like ?",["%$city%"]);
        return json($school);
    }

    /**
     * 修改用户信息
     * @post Int school
     * @return \think\response\Json
     */
    public function Update()
    {
        $user_openid = cookie('openid');
        if (empty($user_openid)) {
            return json(["result" => 'failed', "reason" => "没有登录"], 403);
        }
        $school = input('post.school');
        if (empty($school)) {
            return json(["result" => 'failed', "reason" => "缺少参数school"], 400);
        }
        Db::execute("UPDATE User SET U_school = ? WHERE U_openid = ?", [$school, $user_openid]);
        return json(["result" => "success"]);
    }
}