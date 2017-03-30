<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/30
 * Time: 下午4:52
 */

namespace app\admin\controller;


use think\Db;

class File
{
    public function Index()
    {
        $file_id = input('get.file_id');
        return Db::query("select F_url from File where F_Id = ?",[$file_id])[0];
    }
}