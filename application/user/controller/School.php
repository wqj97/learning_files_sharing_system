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
    public function Index() {
        $school_list = Db::query("select S_Id as Id, S_name as name from School");
        return json($school_list);
    }
}