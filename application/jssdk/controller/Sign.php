<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/11
 * Time: 下午9:35
 */

namespace app\jssdk\controller;
use EasyWeChat\Foundation\Application;
require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/vendor/autoload.php';


class Sign
{
    public function Index()
    {
        $option = require_once $_SERVER['DOCUMENT_ROOT'] . '/extend/wechat-master/config.php';
        $url = input('post.url','https://www.aiyouyi.net.cn');
        $app = new Application($option);
        $js = $app->js;
        $config = $js->setUrl($url)->config(["onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo","onMenuShareQZone"]);
        return json([$config]);
    }
}