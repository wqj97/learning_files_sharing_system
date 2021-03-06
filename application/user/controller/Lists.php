<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/6
 * Time: 上午12:50
 */

namespace app\user\controller;


use think\Db;

class Lists
{
    /**
     * 下载记录
     * @get page Int 页码
     * @return \think\response\Json
     */
    public function download()
    {
        $user_openid = cookie('openid');
        $start = input('get.page',0) * 12;
        $down_list = Db::query("SELECT
                       (SELECT F_Id FROM File WHERE F_Id = D_file_Id) AS 'Id',
                       (SELECT F_name FROM File WHERE F_Id = D_file_Id) AS 'name'
                       FROM Download_record
                       WHERE D_user_openid = ? ORDER BY D_Id DESC LIMIT $start,12", [$user_openid]);
        return json($down_list);
    }

    /**
     * 收藏记录
     * @get page Int 页码
     * @return \think\response\Json
     */
    public function collect()
    {
        $user_openid = cookie('openid');
        $start = input('get.page',0) * 12;
        $collect_list = Db::query("SELECT
                       (SELECT F_Id FROM File WHERE F_Id = C_file_Id) AS 'Id',
                       (SELECT F_name FROM File WHERE F_Id = C_file_Id) AS 'name'
                       FROM Collect_record
                       WHERE C_user_openid = ? ORDER BY C_Id DESC LIMIT $start,12", [$user_openid]);
        return json($collect_list);
    }

    /**
     * 通知记录
     * @get page Int 页码
     * @return \think\response\Json
     */
    public function notice()
    {
        $start = input('get.page',0) * 12;
        $notice_list = Db::query("select N_Id as 'Id',N_title as 'name',N_url as 'url' from Notice_record ORDER BY N_Id DESC LIMIT $start,12");
        return json($notice_list);
    }

    /**
     * 分享记录
     * @get page Int 页码
     * @return \think\response\Json
     */
    public function share()
    {
        $start = input('get.page',0) * 12;
        $user_openid = cookie('openid');
        $notice_list = Db::query("select SH_file_id as 'Id',(SELECT F_name from File where SH_file_id = F_Id) as 'name' from Share_record where SH_user_openid = ? ORDER BY SH_Id DESC LIMIT $start,12",[$user_openid]);
        return json($notice_list);
    }
}