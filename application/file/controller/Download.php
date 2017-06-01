<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/30
 * Time: 下午11:21
 */

namespace app\file\controller;


use think\Db;
use think\Exception;

class Download
{
    /**
     * 下载文件
     * @get file_id
     * @return \think\response\Json || void
     */
    public function Index ()
    {

        $file_id = input("get.file_id");
        $user_openid = empty(cookie('openid')) ? input("get.openid") : cookie('openid');
        if (empty($file_id) || empty($user_openid)) {
            return json("禁止访问", 403);
        }
        try{
            $file_Info = Db::query("SELECT F_url,F_name,F_level,F_ext FROM File WHERE F_Id = ?", [$file_id])[0];
        } catch (Exception $e) {
            echo $e->getCode();
            echo "\n非常抱歉, 文件损坏, 暂时无法下载这个文件";
            echo "<script>window.location.go(-1)</script>";
        }
        $user_info = Db::query("SELECT U_credit,U_school FROM User WHERE U_openid = ?", [$user_openid])[0];
        if (empty($user_info["U_school"])) {
            return json("未绑定学校", 403);
        }
        $user_level = getLevel($user_info["U_credit"]);
        if ($user_level < $file_Info["F_level"]) {
            return json("权限不足", 403);
        }
        Db::execute("UPDATE File SET F_download_count = F_download_count + 1 WHERE F_Id = ?", [$file_id]);
        Db::execute("INSERT INTO Download_record (D_user_openid, D_file_Id,D_user_school_Id) VALUES (?,?,?)", [$user_openid, $file_id, $user_info["U_school"]]);
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
//            echo "<iframe style='width:100%;height: 100%;' frameborder='0' src='{$file_Info["F_url"]}'></iframe>";
            Header("Location: $file_Info[F_url]");
        } else {
            Header("Content-Disposition: attachment; filename=" . $file_Info["F_name"] . "." . $file_Info["F_ext"]);
            Header("Content-type: application/pdf");
            Header("Accept-Ranges: bytes");
            Header("Location: $file_Info[F_url]");
        }
    }
}