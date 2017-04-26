<?php

// 应用公共文件
/**
 * @param $key String 键名
 * @return String 键值
 */
function Server_Setting ($key)
{
    return \think\Db::query("select S_value from Setting where S_key = '$key'")[0]['S_value'];
}

/**
 * 返回用户等级
 * @param $credit
 * @return int
 */
function getLevel ($credit)
{
    $level = json_decode(Server_Setting('level'),true);//0,10,50,100
    for ($i = 0; $i < 4; $i++) {
        if ($credit <= (Int)$level[$i + 1]) return $i + 1;
    }
    return 3;
}