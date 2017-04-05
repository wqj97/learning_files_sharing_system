<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/29
 * Time: 下午5:49
 */

namespace app\user\controller;


use think\Db;

class Index
{
    /**
     * 获取用户信息
     * @return \think\response\Json
     */
    public function Index()
    {
        $user_openid = cookie('openid');
        if (empty($user_openid)) {
            return json(["result" => 'failed', "reason" => "没有登录"], 403);
        }
        $user_info = Db::query("SELECT U_name,U_school,U_credit,U_head FROM User WHERE U_openid = ?", [$user_openid])[0];
        if ($user_info['U_school'] == 'null') {
            $user_info['U_school'] = "未绑定学校";
        } else {
            $user_info['U_school'] = Db::query('SELECT S_name FROM School WHERE S_Id = ?', [$user_info['U_school']])[0]['S_name'];
        }
        $user_info['level'] = $this->getLevel($user_info['U_credit']);
        return json($user_info);
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
        return 0;
    }
}