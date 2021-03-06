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
     * 科目习题: 2
     * 科目精华: 4
     * 英语: 8
     * 考研: 16
     * 资格考试: 32
     * 工具书: 64
     * 其他: 128
     * 病例: 256
     */
    public function Index()
    {
        $name = input('get.name', '');
        $page = input('get.page', 0);
        $type = input('get.type', "[0]");
        $start = $page * 12;
        if ($type == '[0]') {
            $files = Db::query("select F_Id,F_name,F_type,F_level,F_ext,F_download_count,(SELECT count(*) from Collect_record where C_file_Id = F_Id) as 'collect_record',F_view_count,F_school from File where F_name like ? and F_type is NOT NULL order by `F_join_time` desc LIMIT $start,12", ['%' . $name . '%']);
        } else {
            $type = json_decode($type);
            $sql = "SELECT F_Id,F_name,F_type,F_level,F_ext,F_download_count,(SELECT count(*) FROM Collect_record WHERE C_file_Id = F_Id) AS 'collect_record',F_view_count,F_school FROM File WHERE F_name LIKE ? AND F_type IS NOT NULL AND ";
            foreach ($type as $key => $each) {
                $sql = $sql . 'F_type = ' . $each;
                if ($key != (count($type) -1)) {
                    $sql .= ' or ';
                }
            }
            $sql = $sql . " order by `F_join_time` desc LIMIT $start,12";
            $files = Db::query($sql, ['%' . $name . '%']);
        }
        return json($files);
    }
}