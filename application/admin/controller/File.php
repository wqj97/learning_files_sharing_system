<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/30
 * Time: 下午4:52
 */

namespace app\admin\controller;


use think\Db;
use think\db\Query;
use think\Debug;

class File
{
    /**
     * 获取文件地址
     * @return mixed
     */
    public function Index()
    {
        $file_id = input('get.file_id');
        return Db::query("SELECT * FROM File WHERE F_Id = ?", [$file_id])[0];
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
        $file_name = input('get.file_name');
        Db::execute("UPDATE File SET F_type = ?, F_level = ?, F_name = ? WHERE F_Id = ?", [$file_type_code, $file_level, $file_name, $file_id]);
        $this->Transfer($file_id);
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
        $file_src = Db::query("SELECT F_url FROM File WHERE F_Id = ?", [$file_id])[0]["F_url"];
        unlink($_SERVER["DOCUMENT_ROOT"] . $file_src);
        Db::execute("DELETE FROM File WHERE F_Id = ?", [$file_id]);
        return json(["result" => "success"]);
    }

    /**
     * 管理员上传文件
     * @post file 文件
     * @post file_name 文件名
     * @post file_type 文件类型
     * @post file_level 文件等级
     * @return \think\response\Json
     */
    public function Add()
    {
        $file = request()->file('file');
        $file_hash = $file->hash('md5');
        $file_name = $file->getInfo()["name"];
        $hashInDb = Db::query("SELECT * FROM aiuyi.File WHERE F_hash = ?", [$file_hash]);
        if (!empty($hashInDb)) {
            return json(["result" => "failed", "reason" => "$file_name 文件已存在"], 403);
        }
        $info = $file->move($_SERVER['DOCUMENT_ROOT'] . '/upload');
        $file_ext = $info->getExtension();
        $file_type = input('post.file_type');
        $file_level = input('post.file_level');
        $file_src = '/upload/' . date('Ymd') . "/" . $info->getFilename();
        Db::execute("INSERT INTO aiuyi.File (F_hash, F_name, F_ext, F_type, F_url, F_user_openid,F_level) VALUES (?,?,?,?,?,?,?)", [$file_hash, $file_name, $file_ext, $file_type, $file_src, 'owFqbv0psVKX1WwKHFylzNXqGL34', $file_level]);
        $insert_Id = Db::query("select LAST_INSERT_ID()")[0]["LAST_INSERT_ID()"];
        $this->Transfer($insert_Id);
        return json(["result" => "success"]);
    }

    /**
     * 管理员获取文件信息
     * @get file_id 文件Id
     * @return \think\response\Json
     */
    public function getInfo()
    {
        $file_id = input('get.file_id');
        $file_info = Db::query("SELECT * FROM File WHERE F_Id = ?", [$file_id])[0];
        return json($file_info);
    }

    private function Transfer($file_id)
    {
        $server_file_url = Db::query("SELECT F_url,F_ext FROM File WHERE F_Id = ?", [$file_id])[0];
        if (mb_strtolower($server_file_url["F_ext"]) != "pdf") {
            Db::execute("UPDATE File SET F_transfer_url = ? WHERE aiuyi.File.F_Id = ?", ["Cant't transfer", $file_id]);
            return true;
        }
        $transfer_url = [];
        for ($i = 0; $i < 5; $i++) {
            $file_url = "/home/wwwroot/wx.97qingnian.com" . $server_file_url["F_url"] . "[{$i}]";
            $jpg_url = $file_url . ".jpg";
            $result = 0;
            $output = [];
            exec("convert -verbose -density 150 -trim {$file_url} -quality 100 -flatten {$jpg_url}", $output, $result);
            if (!empty($output)) {
                break;
            }
            $transfer_url[] = $server_file_url["F_url"] . "[$i].jpg";
        }
        $transfer_url = json_encode($transfer_url);
        Db::execute("UPDATE File SET F_transfer_url = ? WHERE aiuyi.File.F_Id = ?", [$transfer_url, $file_id]);
        return true;
    }
}