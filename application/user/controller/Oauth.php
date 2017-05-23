<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/29
 * Time: 下午5:42
 */

namespace app\user\controller;


use EasyWeChat\Foundation\Application;
use think\Cookie;
use think\Db;

require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/vendor/autoload.php';

class Oauth
{
    protected $app;

    /**
     * Oauth constructor.
     */
    function __construct ()
    {
        $option = require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/config.php';
        $this->app = new Application($option);
    }

    public function index ()
    {
        $redirect = input('get.url');
        if (!empty($redirect)) {
            Cookie::set('redirect_url', $redirect, 120);
        }
        if (!cookie('?openid')) {
            $response = $this->app->oauth->scopes(['snsapi_userinfo'])->redirect();
            return $response->send();
        } else {
            if (empty($redirect)) {
                header('Location:/home/?#');
            } else {
                header("location:{$redirect}");
            }
            return json(null, 302);
        }
    }

    public function Check ()
    {
        $user = $this->app->oauth->user();
        $userInDb = Db::query("select * from User where `U_openid` = '$user[id]'");
        if (empty($userInDb)) {
            Db::execute("insert into User (U_name,U_openid,U_head) values ('$user[name]','$user[id]','$user[avatar]')");
        } else {
            Db::execute("update User set `U_name` = '$user[name]',`U_head` = '$user[avatar]' where `U_openid` = '$user[id]'");
        }
        cookie('openid', $user['id']);
        $redirect = cookie('redirect_url');
        if (empty($redirect)) {
            header('location:/home');
        } else {
            header("location:{$redirect}");
        }
        return;
    }

    public function debug ($Id = 1)
    {
        if ($Id != 1) {
            $openid = Db::query("select U_openid from User where U_Id = $Id")[0]["U_openid"];
            cookie('openid', $openid);
            header("location:/home");
        } else {
            cookie('openid', 'owFqbv40P9R9f22SRTLjfwRy2vVE');
            header("location:/home");
        }
        return json(null, 302);
    }

    public function truncate ()
    {
        cookie('openid', null);
        header('location:/user/oauth');
        return json(null, 302);
    }
}