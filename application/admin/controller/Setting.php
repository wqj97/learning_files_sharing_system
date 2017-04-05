<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/5
 * Time: 下午12:30
 */

namespace app\admin\controller;


use think\Db;

class Setting
{
    /**
     * 修改设置
     * @return \think\response\Json
     */
    public function Index()
    {
        $A_admin = input('post.A_user');
        $A_pwd = input('post.A_pwd');
        $file_type = input('post.file_type');
        $file_credit = input('post.file_credit');
        $level = input('post.level');
        Db::execute("update Setting set S_value = ? where S_key = 'A_user'",[$A_admin]);
        Db::execute("update Setting set S_value = ? where S_key = 'A_pwd'",[$A_pwd]);
        Db::execute("update Setting set S_value = ? where S_key = 'file_type'",[$file_type]);
        Db::execute("update Setting set S_value = ? where S_key = 'file_credit'",[$file_credit]);
        Db::execute("update Setting set S_value = ? where S_key = 'level'",[$level]);
        return json(["result" => "success"]);
    }
}