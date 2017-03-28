<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/27
 * Time: 下午8:46
 */


namespace app\oauth\controller;

use EasyWeChat\Foundation\Application;
use think\Db;
use think\session;

require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/vendor/autoload.php';

class Index
{
    protected $app;

    function __construct()
    {
        $option = require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/config.php';
        $this->app = new Application($option);
    }

    public function index()
    {
        cookie(['prefix' => 'Aiuyi_', 'expire' => 604800]);
        if (!cookie('?openid')) {
            $response = $this->app->oauth->scopes(['snsapi_userinfo'])->redirect();
            return $response->send();
        } else {
            header('Location:/home');
            return '';
        }
    }

    public function Check()
    {
        $user = $this->app->oauth->user();
        $userInDb = Db::query("select * from User where `U_openid` = '$user[id]'");
        if (empty($userInDb)) {
            Db::execute("insert into User (U_name,U_openid,U_head) values ('$user[name]','$user[id]','$user[avatar]')");
        } else {
            Db::execute("update User set `U_name` = '$user[name]',`U_head` = '$user[avatar]' where `U_openid` = '$user[id]'");
        }
        cookie(['prefix' => 'Aiuyi_', 'expire' => 604800]);
        cookie('openid',$user['id']);
        header('location:/home');
        return ;
    }

    public function debug()
    {
        cookie(['prefix' => 'Aiuyi_', 'expire' => 604800]);
        cookie('openid','owFqbv40P9R9f22SRTLjfwRy2vVE');
    }
}