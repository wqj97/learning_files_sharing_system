<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/28
 * Time: 下午1:14
 */

namespace app\search\controller;


use function foo\func;
use think\Db;

class Index
{
    /**
     * 搜索
     * @get name: 文件名
     * @get page: 页码, 默认每页12个
     * @get $type = 0: 文件类型
     * type:
        科目习题: 2
        科目精华: 4
        英语: 8
        考研: 16
        资格考试: 32
        工具书: 64
        其他: 128
     */
    public function Index()
    {
        $name = input('get.name');
        $page = input('get.page');
        $type = input('get.type', [0]);
        $start = $page * 12;
        if ($type == '[0]') {
            if (empty($name)) {
                $files = Db::query("select * from File order by `F_join_time` desc LIMIT $start,12");
            }else{
                $files = Db::query("select * from File where F_name = ? order by `F_join_time` desc LIMIT $start,12", [$name]);
            }
        } else {
            $type = json_decode($type);
            $sql = "select * from File where F_name = ?";
            foreach ($type as $each) {
                $sql = $sql.' or F_type = '.$each.' ';
            }
            $sql = $sql."order by `F_join_time` desc LIMIT $start,12";
            echo $sql;
            $files = Db::query($sql, [$name]);
        }
        return json($files);
    }
}