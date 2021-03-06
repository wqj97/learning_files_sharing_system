<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/29
 * Time: 上午11:47
 */

namespace app\file\controller;


use think\Db;

class Collect
{
    /**
     * @get file_id 文件Id
     * @return \think\response\Json
     */
    public function Index() {
        $file_id = input('get.file_id');
        if (empty($file_id)) {
            return json(["reason" => "缺少参数"],400);
        }
        $user_id = cookie('openid');
        $file_collected = Db::query("select * from Collect_record where C_file_Id = ? and C_user_openid = ?",[$file_id,$user_id]);
        $file_collected = !empty($file_collected);
        if ($file_collected) {
            Db::execute("delete from Collect_record where C_file_Id = ?",[$file_id]);
            return json(["result" => "success","disCollect"]);
        } else {
            Db::execute("insert into Collect_record (C_user_openid, C_file_Id) VALUES (?,?)",[$user_id,$file_id]);
            return json(["result" => "success","Collected"]);
        }
    }
}