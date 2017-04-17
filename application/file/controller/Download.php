<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/30
 * Time: 下午11:21
 */

namespace app\file\controller;


use think\Db;

class Download
{
    /**
     * 下载文件
     * @get file_id
     * @return \think\response\Json || void
     */
    public function Index()
    {

        $file_id = input("get.file_id");
        $user_openid = cookie('openid');
        if (empty($file_id) || empty($user_openid)) {
            return json("禁止访问", 403);
        }
        $file_Info = Db::query("SELECT F_url,F_name,F_level,F_ext FROM File WHERE F_Id = ?", [$file_id])[0];
        $user_credit = Db::query("SELECT U_credit FROM User WHERE U_openid = ?", [$user_openid])[0];
        $user_level = $this->getLevel($user_credit);
        if ($user_level < $file_Info["F_level"]) {
            return json("权限不足", 403);
        }
        Db::execute("UPDATE File SET F_download_count = F_download_count + 1 WHERE F_Id = ?", [$file_id]);
        Db::execute("INSERT INTO Download_record (D_user_openid, D_file_Id) VALUES (?,?)", [$user_openid, $file_id]);
        $file_obj = new \SplFileObject($_SERVER['DOCUMENT_ROOT'] . $file_Info["F_url"], 'r');
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            echo "<iframe style='width:100%;height: 100%;' frameborder='0' src='{$file_Info["F_url"]}'></iframe>";
        } else {
            Header("Content-Disposition: attachment; filename=" . $file_Info["F_name"] . "." . $file_Info["F_ext"]);
            Header("Content-type: application/pdf");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length:" . $file_obj->getSize());
            foreach ($file_obj as $key => $val) {
                echo $val;
            }
        }
    }

    /**
     * 返回用户等级
     * @param $credit
     * @return int
     */
    private function getLevel($credit)
    {
        $level = json_decode(Server_Setting('level'));
        foreach ($level as $levelNum => $each) {
            if ($credit <= $each) {
                return $levelNum;
            }
        }
        return 3;
    }
}