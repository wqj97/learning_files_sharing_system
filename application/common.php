<?php

// 应用公共文件
/**
 * @param $key String 键名
 * @return String 键值
 */
function Server_Setting ($key) {
    return \think\Db::query("select S_value from Setting where S_key = '$key'")[0]['S_value'];
}
