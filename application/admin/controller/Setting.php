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
        $price = input('post.price');
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'A_user'", [$A_admin]);
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'A_pwd'", [$A_pwd]);
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'file_type'", [$file_type]);
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'file_credit'", [$file_credit]);
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'level'", [$level]);
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'price'", [$price]);
        return json(["result" => "success"]);
    }

    public function Banner_file_upload()
    {
        $file = request()->file('file');
        $info = $file->move($_SERVER['DOCUMENT_ROOT'] . '/upload/Banner');
        $file_src = '/upload/Banner/' . date('Ymd') . "/" . $info->getFilename();
        return json(["result" => "success", "src" => $file_src]);
    }

    public function Banner_save()
    {
        $banner = input('post.banner');
        Db::execute("UPDATE Setting SET S_value = ? WHERE S_key = 'banner'", [$banner]);
        return json(["result" => "success"], 200);
    }
}