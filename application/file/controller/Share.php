<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/9
 * Time: 上午9:23
 */

namespace app\file\controller;


use think\Db;

class Share
{
    /**
     * 分享文件
     * @return \think\response\Json
     */
    public function Index()
    {
        $file_id = input('post.file_id');
        $user_openid = cookie('openid');
        $share_credit = Server_Setting('share_credit');
        Db::execute("update User set U_credit = U_credit + $share_credit where U_openid = ?",[$user_openid]);
        Db::execute("Insert into Share_record (SH_user_openid, SH_file_id) VALUES (?,?)",[$user_openid,$file_id]);
        return json(["result" => "success"]);
    }

}