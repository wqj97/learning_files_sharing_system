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
        $user_info['level'] = $this->getLevel($user_info['U_credit']);
        $banner = json_decode(Server_Setting('banner'));
        $top_file = Db::query("select F_Id,F_name,(SELECT count(*) from Comment where C_file_Id = F_Id) as 'comment_count',F_download_count,(SELECT count(*) from Collect_record where C_file_Id = F_Id) as 'collect_record',F_view_count,F_ext from File where F_type is NOT NULL ORDER BY F_view_count LIMIT 0,12");
        return json(["userInfo" => $user_info,"banner" => $banner,"top_file" => $top_file]);
    }

    /**
     * 获取用户等级
     * @param $credit
     * @return int|string
     */
    private function getLevel($credit)
    {
        $level = json_decode(Server_Setting('level'));
        foreach ($level as $levelNum => $each) {
            if ($credit <= $each) {
                return $levelNum;
            }
        }
        return 0;
    }
}