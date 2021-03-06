<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/5
 * Time: 上午9:16
 */

namespace app\index\controller;


use think\Db;
use think\Debug;

class home
{
    /**
     * 获取首页信息
     * @return \think\response\Json
     */
    public function Index()
    {
        $user_openid = cookie('openid');
        if (empty($user_openid)) {
            return json(["result" => 'failed', "reason" => "没有登录"], 403);
        }
        $user_info = Db::query("SELECT U_name,U_school,U_credit,U_head FROM User WHERE U_openid = ?", [$user_openid])[0];
        if (empty($user_info['U_school'])) {
            $user_info['U_school'] = "未绑定学校";
        } else {
            $user_info['U_school'] = Db::query('SELECT S_name FROM School WHERE S_Id = ?', [$user_info['U_school']])[0]['S_name'];
        }
        $user_info['level'] = getLevel($user_info['U_credit']);
        $banner = json_decode(Server_Setting('banner'));
        $top_file = [];
        $top_file_by_down_and_school = Db::query("SELECT D_file_Id
              FROM Download_record
              WHERE D_user_school_Id = (
              SELECT U_school from User where U_openid = '$user_openid'
              )
              GROUP BY D_file_Id
              ORDER BY COUNT(0) DESC LIMIT 0,12");
        foreach ($top_file_by_down_and_school as $item) {
            $top_file_db = Db::query("select F_Id,F_name,F_level,F_download_count,
            (SELECT count(*) from Collect_record where C_file_Id = F_Id) as 'collect_record',F_view_count,F_ext from File where F_Id = $item[D_file_Id]");
            if (!empty($top_file_db)){
                $top_file[] = $top_file_db[0];
            }
        }
        if (count($top_file_by_down_and_school) < 12) {
            $need_select = 12 - count($top_file_by_down_and_school);
            $top_file_by_view = Db::query("select F_Id,F_name,F_level,F_download_count,(SELECT count(*) from Collect_record where C_file_Id = F_Id) as 
'collect_record',F_view_count,F_ext from File where F_type is NOT NULL ORDER BY F_view_count LIMIT 0,$need_select");
            foreach ($top_file_by_view as $item) {
                $top_file[] = $item;
            }
        }
        return json(["userInfo" => $user_info,"banner" => $banner,"top_file" => $top_file]);
    }
}