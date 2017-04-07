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
        $type = input('get.type', "[0]");
        $start = $page * 12;
        if ($type == '[0]') {
            if (empty($name)) {
                $files = Db::query("select F_Id,F_name,F_type,F_level,(SELECT count(*) from Comment where C_file_Id = F_Id) as 'comment_count',F_download_count,(SELECT count(*) from Collect_record where C_file_Id = F_Id) as 'collect_record',F_school from File order by `F_join_time` desc LIMIT $start,12");
            }else{
                $files = Db::query("select F_Id,F_name,F_type,F_level,(SELECT count(*) from Comment where C_file_Id = F_Id) as 'comment_count',F_download_count,(SELECT count(*) from Collect_record where C_file_Id = F_Id) as 'collect_record',F_school from File where F_name like ? order by `F_join_time` desc LIMIT $start,12", ['%'.$name.'%']);
            }
        } else {
            $type = json_decode($type);
            $sql = "select F_Id,F_name,F_type,F_level,(SELECT count(*) from Comment where C_file_Id = F_Id) as 'comment_count',F_download_count,(SELECT count(*) from Collect_record where C_file_Id = F_Id) as 'collect_record',F_school from File where F_name like ?";
            foreach ($type as $each) {
                $sql = $sql.' or F_type = '.$each.' ';
            }
            $sql = $sql."order by `F_join_time` desc LIMIT $start,12";
            $files = Db::query($sql, ['%'.$name.'%']);
        }
        return json($files);
    }
}