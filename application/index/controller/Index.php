<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> 感谢ThinkPHP提供的高可用框架<br/><span style="font-size:30px">开发:万千钧 张尧<br> 合作联系微信:wanqj97 vv77303565</span></p><p><img src="/upload/wechat.JPG" width="500px"><img src="/upload/WechatY.jpeg" width="500px"></p></div>';
    }
}
