<?php

namespace app\pay\controller;
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/6
 * Time: 上午1:10
 */
class Price
{
    /**
     * 获取价格列表
     * @return \think\response\Json
     */
    public function Index()
    {
        $price = Server_Setting('price');
        return json($price);
    }
}