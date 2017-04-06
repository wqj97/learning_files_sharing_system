<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/29
 * Time: 上午10:58
 */

namespace app\file\controller;


use think\Db;

class Comment
{
    /**
     * 新建评论
     * @post file_id Int 文件Id
     * @post content String 评论内容
     * @return \think\response\Json
     */
    public function new()
    {
        $file_id = input('post.file_id');
        $comment_content = input('post.content');
        $comment_user = cookie('openid');
        if (empty($file_id) || empty($comment_content) || empty($comment_user)) {
            return json(["result" => "failed", "reason" => "缺少参数"], 400);
        }
        Db::execute('INSERT INTO Comment (C_user, C_content, C_file_Id) VALUES (?,?,?)', [$comment_user, $comment_content, $file_id]);
        return json(["result" => "success"]);
    }

    /**
     * 获取评论
     * @get file_id Int 文件Id
     * @get page Int 页码
     * @return \think\response\Json
     */
    public function Index()
    {
        $file_id = input('get.file_id');
        $page = input('get.page',0);
        $start = $page * 12;
        if (empty($file_id)) {
            return json(["result" => "failed", "reason" => "缺少参数"], 400);
        }
        $comments = Db::query("select C_content,C_join_time,(select U_name FROM User where U_openid = C_user) as 'U_name',(select U_head FROM User where U_openid = C_user) as 'U_head' from Comment where C_file_Id = ? LIMIT ?,8",[$file_id,$start]);
        return json($comments);
    }
}