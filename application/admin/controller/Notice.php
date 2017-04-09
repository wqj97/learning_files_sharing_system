<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/9
 * Time: 上午10:30
 */

namespace app\admin\controller;


use think\Db;

class Notice
{
    public function get()
    {
        $notice_id = input('get.notice_id');
        return json(Db::query("SELECT * FROM aiuyi.Notice_record WHERE N_Id = ?", [$notice_id])[0]);
    }

    public function new()
    {
        $notice_title = input('post.notice_title');
        $notice_url = input('post.notice_url');
        Db::execute("INSERT INTO aiuyi.Notice_record (N_title, N_url) VALUES (?,?)", [$notice_title, $notice_url]);
        return json(["result" => "success"]);
    }

    public function edit()
    {
        $notice_id = input('post.notice_id');
        $notice_title = input('post.notice_title');
        $notice_url = input('post.notice_url');
        Db::execute("update Notice_record set N_title = ?,N_url = ? where N_Id = ?",[$notice_title,$notice_url,$notice_id]);
        return json(["result" => "success"]);
    }

    public function delete()
    {
        $notice_id = input('post.notice_id');
        Db::execute("delete from aiuyi.Notice_record where N_Id = ?",[$notice_id]);
        return json(["result" => "success"]);
    }
}