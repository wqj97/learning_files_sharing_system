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
    /**
     * 获取文件地址
     * @return mixed
     */
    public function Index()
    {
        $file_id = input('get.file_id');
        return Db::query("select F_url from File where F_Id = ?",[$file_id])[0];
    }

    /**
     * 审批通过
     * @get Int file_id
     * @get Int file_type_code
     * @return \think\response\Json
     */
    public function Agree()
    {
        $file_id = input('get.file_id');
        $file_level = input('get.file_level');
        $file_type_code = input('get.file_type_code');
        Db::execute("update File set F_type = ?, F_level = ? where F_Id = ?",[$file_type_code,$file_level,$file_id]);
        return json(["result" => "success"]);
    }

    /**
     * 审批拒绝
     * @get Int file_id
     * @return \think\response\Json
     */
    public function Refuse()
    {
        $file_id = input('get.file_id');
        $file_src = Db::query("select F_url from File where F_Id = ?",[$file_id])[0]["F_url"];
        unlink($_SERVER["DOCUMENT_ROOT"].$file_src);
        Db::execute("delete from File where F_Id = ?",[$file_id]);
        return json(["result" => "success"]);
    }

    /**
     * 管理员上传文件
     * @post file_name 文件名
     * @post file_type 文件类型
     * @post file_level 文件等级
     * @return \think\response\Json
     */
    public function add() {
        $file = request()->file('file');
        $file_hash = $file->hash('md5');
        $info = $file->move($_SERVER['DOCUMENT_ROOT'] . '/upload');
        $file_ext = $info->getExtension();
        $file_name = input('post.file_name');
        $file_type = input('post.file_type');
        $file_level = input('post.file_level');
        return json();
    }
}