<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/27
 * Time: 下午8:43
 */
return [
    'debug'  => true,
    'app_id' => 'wxe77f6f9336acb060',
    'secret' => 'dbbcaae710679d606b5cb1e69255f2ce',
    'log' => [
        'level' => 'debug',
        'file'  => __DIR__.'/tmp/easywechat.log', // XXX: 绝对路径！！！！
    ],
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
        'callback' => '/user/oauth/check',
    ],
    'url' => 'wx.97qingnian.com'
];