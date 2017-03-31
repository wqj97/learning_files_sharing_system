<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/30
 * Time: 上午10:15
 */

namespace app\admin\controller;


use think\Response;

class login
{
    public function Index()
    {
        $admin_user = input('post.user');
        $admin_pwd = input('post.pwd');
        $userInDb = Server_Setting('A_user');
        $pwdInDb = Server_Setting('A_pwd');
        if ($admin_user != $userInDb || $admin_pwd != $pwdInDb) {
            http_response_code(403);
            return '<h1>密码错误</h1><script>setTimeout(function() {location.href=\'index.html\'},1000)</script>';
        } else {
            header("Location: File-check.php");
            session('Login',1);
            return json(null,302);
        }
    }
}