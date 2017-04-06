<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/5
 * Time: 上午1:03
 */

namespace app\admin\controller;


use think\Db;

class Comment
{
    /**
     * 获取评论
     *
     * @get comment_id
     * @return \think\response\Json
     */
    public function Index()
    {
        $comment_id = input("get.comment_id");
        return json(Db::query("select C_content from Comment where C_Id = ?",[$comment_id])[0]);
    }

    /**
     * 修改评论
     * @post comment_id
     * @post comment_content
     * @return \think\response\Json
     */
    public function save()
    {
        $comment_id = input('post.comment_id');
        $comment_content = input('post.comment_content');
        Db::execute("UPDATE Comment SET C_content = ? WHERE C_Id = ?", [$comment_content, $comment_id]);
        return json(["result"=>"successs"]);
    }

    /**
     * 删除评论
     * @get comment_id
     * @return \think\response\Json
     */
    public function delete()
    {
        $comment_id = input('get.comment_id');
        Db::execute("delete from Comment where C_Id = ?",[$comment_id]);
        return json(["result"=>"successs"]);
    }
}