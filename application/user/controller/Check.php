<?php
namespace app\user\controller;
require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/vendor/autoload.php';
use EasyWeChat\Foundation\Application;
use think\Debug;

class Check
{
    public function Index ()
    {
        $openid = cookie('openid');
        $option = require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/config.php';
        $app = new Application($option);
        $result = $app->user->get($openid)->subscribe ? true : false;
        return json($result);
    }
}