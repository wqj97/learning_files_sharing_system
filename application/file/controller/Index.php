<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/28
 * Time: 下午3:49
 */

namespace app\file\controller;


use think\Db;

class Index
{
    /**
     * 查询文件信息
     * @get file_id
     * @return \think\response\Json
     */
    public function Index() {
        $Id = input('get.file_id');
        $openid = cookie('openid');
        $file_info = Db::query("select * from File where F_Id = ?",[$Id])[0];
        Db::execute("update File set F_view_count = F_view_count + 1 where F_Id = ?",[$Id]);
        $file_info["comment_count"] = Db::query("select count(0) from Comment where C_file_Id = $file_info[F_Id]")[0]["count(0)"];
        $file_info["like_count"] = Db::query("select count(0) from Collect_record where C_file_Id = $file_info[F_Id]")[0]["count(0)"];
        $file_collected = Db::query("select * from Collect_record where C_file_Id = $file_info[F_Id] and C_user_openid = '$openid'");
        $file_info["liked"] = !empty($file_collected);
        return json($file_info);
    }
}