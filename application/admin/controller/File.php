<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/30
 * Time: 下午4:52
 */

namespace app\admin\controller;

use app\admin\model\COS;
use think\Db;
use think\db\Query;
use think\Debug;
use think\Loader;
use think\Log;

class File
{
    /**
     * 获取文件地址
     * @return mixed
     */
    public function Index ()
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
    public function Agree ()
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
    public function Refuse ()
    {
        $file_id = input('get.file_id');
        $file_src = Db::query("SELECT F_url,F_transfer_url,F_on_cos FROM File WHERE F_Id = ?", [$file_id])[0];
        if ($file_src["F_on_cos"] == 1) {
            if ($delete_response = $this->deleteCosFile($file_id)) {
                return json(["result" => "success"]);
            } else {
                return json(["result" => "failed", 'reson' => $delete_response], 500);
            }
        }
        unlink($_SERVER["DOCUMENT_ROOT"] . $file_src["F_url"]);
        foreach (json_decode($file_src["F_transfer_url"]) as $preview_url) {
            unlink($_SERVER["DOCUMENT_ROOT"] . $preview_url);
        }
        Db::execute("DELETE FROM File WHERE F_Id = ?", [$file_id]);
        return json(["result" => "success"]);
    }

    /**
     * 删除文件, 与审批拒绝不同的是, 删除文件会把远程COS的文件也删除
     * @param $file_id Int 文件Id
     * @return Boolean 处理结果
     */

    public function deleteCosFile ($file_id)
    {
        $file_info = Db::query("SELECT * FROM File WHERE F_Id = ?", [$file_id])[0];
        $cos = new COS();
        foreach (json_decode($file_info["F_transfer_url"]) as $item) {
            $cos->delete($item);
        }
        $ext_result = $cos->delete($file_info["F_url"]);
        if ($ext_result["code"] != 0) {
            return false;
        }
        Db::execute("DELETE FROM File WHERE F_Id = ?", [$file_id]);
        return true;
    }

    /**
     * 管理员上传文件
     * @post file 文件
     * @post file_name 文件名
     * @post file_type 文件类型
     * @post file_level 文件等级
     * @return \think\response\Json
     */
    public function Add ()
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
    public function getInfo ()
    {
        $file_id = input('get.file_id');
        $file_info = Db::query("SELECT * FROM File WHERE F_Id = ?", [$file_id])[0];
        return json($file_info);
    }

    public function Transfer ($file_id)
    {
        $server_file_url = Db::query("SELECT F_url,F_ext FROM File WHERE F_Id = ?", [$file_id])[0];
        if (mb_strtolower($server_file_url["F_ext"]) != "pdf") {
            Db::execute("UPDATE File SET F_transfer_url = ? WHERE aiuyi.File.F_Id = ?", ["[]", $file_id]);
            $this->SyncToCOS($file_id);
            return true;
        }
        $transfer_url = [];
        $total_page = $this->getPageTotal("/home/wwwroot/wx.97qingnian.com" . $server_file_url["F_url"]);
        $page_start = floor($total_page * 0.45);
        $page_end = floor($total_page * 0.65);
        if ($page_end - $page_start < 1) {
            $page_end = $page_start + 1;
        }
        for ($i = $page_start; $i < $page_end; $i++) {
            $file_url = "/home/wwwroot/wx.97qingnian.com" . $server_file_url["F_url"] . "[{$i}]";
            $jpg_url = $file_url . ".jpg";
            $result = 0;
            $output = [];
            exec("convert -verbose -density 150 -trim {$file_url} -quality 100 -flatten {$jpg_url}", $output, $result);
            if (!empty($output)) {
                break;
            }
            $server_file_url["F_url"] = str_replace("http:", "", $server_file_url["F_url"]);
            $transfer_url[] = $server_file_url["F_url"] . "[$i].jpg";
        }
        $transfer_url = json_encode($transfer_url);
        Db::execute("UPDATE File SET F_transfer_url = ? WHERE aiuyi.File.F_Id = ?", [$transfer_url, $file_id]);
        $this->SyncToCOS($file_id);
        return true;
    }

    /**
     * 上传文件到COS
     * @param $local_path String 本地文件路径
     * @param $remote_path String 远程文件路径
     * @return array|mixed COS访问路径
     */
    private function uploadToCOS ($local_path, $remote_path)
    {
        $cos = new COS();
        $excute_result = $cos->upLoad($local_path, $remote_path);
        if ($excute_result["code"] == 0) {
            Log::error($excute_result['message']);
            str_replace("http:", "", $excute_result["data"]["access_url"]);
        }
        return $excute_result;
    }

    /**
     * 需要同步的文件Id
     * 如果同步成功, 会删除本地文件
     * @param $file_id
     * @return bool
     */
    private function SyncToCOS ($file_id)
    {
        $file_path = Db::query("SELECT F_url,F_transfer_url FROM File WHERE F_Id = ?", [$file_id])[0];
        $raw_file = $_SERVER["DOCUMENT_ROOT"] . $file_path["F_url"];
        $transfered_file = json_decode($file_path["F_transfer_url"]);
        $raw_file_upload_result = $this->uploadToCOS($raw_file, $file_path["F_url"]);
        if ($raw_file_upload_result["code"] != 0) {
            return false;
        } else {
            $remote_raw_url = str_replace("http:", "", $raw_file_upload_result["data"]["access_url"]);
        }
        $remote_transfer_file = [];
        foreach ($transfered_file as $item) {
            $upload_result = $this->uploadToCOS($_SERVER["DOCUMENT_ROOT"] . $item, $item);
            if ($upload_result["code"] != 0) {
                return false;
            } else {
                $remote_transfer_file[] = str_replace("http:", "", $upload_result["data"]["access_url"]);
            }
        }
        $remote_transfer_file = json_encode($remote_transfer_file);
        Db::execute("UPDATE File SET F_url = ?,F_transfer_url = ?, F_on_cos = 1 WHERE F_Id = ?", [$remote_raw_url, $remote_transfer_file, $file_id]);
        unlink($raw_file);
        foreach ($transfered_file as $item) {
            unlink($_SERVER["DOCUMENT_ROOT"] . $item);
        }
        return true;
    }

    public function syncScript ()
    {
        echo "\r\n";
        $un_upload_files = Db::query("SELECT * FROM File WHERE F_on_cos = 0 AND F_type IS NOT NULL");
        foreach ($un_upload_files as $key => $item) {
            $raw_file = "/home/wwwroot/wx.97qingnian.com" . $item["F_url"];
            $transfered_file = json_decode($item["F_transfer_url"]);
            $raw_file_upload_result = $this->uploadToCOS($raw_file, $item["F_url"]);
            if ($raw_file_upload_result["code"] != 0) {
                continue;
            } else {
                $remote_raw_url = $raw_file_upload_result["data"]["access_url"];
            }
            $remote_transfer_file = [];
            foreach ($transfered_file as $local_transfer_file_url) {
                $upload_result = $this->uploadToCOS("/home/wwwroot/wx.97qingnian.com" . $local_transfer_file_url, $local_transfer_file_url);
                if ($upload_result["code"] != 0) {
                    continue;
                } else {
                    $remote_transfer_file[] = $upload_result["data"]["access_url"];
                }
            }
            $remote_transfer_file = json_encode($remote_transfer_file);
            Db::execute("UPDATE File SET F_url = ?,F_transfer_url = ?,F_on_cos = 1 WHERE F_Id = ?", [$remote_raw_url, $remote_transfer_file, $item["F_Id"]]);
            unlink($raw_file);
            foreach ($transfered_file as $local_transfer_file_url) {
                unlink("/home/wwwroot/wx.97qingnian.com" . $local_transfer_file_url);
            }
            echo "Id: $item[F_Id], 文件名: $item[F_name], 传送完成\r\n";
        }
    }

    public function transferScript ()
    {
        $untrans_file_list = Db::query("SELECT * FROM File WHERE F_ext = 'pdf' AND F_transfer_url = '[]'");
        foreach ($untrans_file_list as $item) {
            $this->Transfer($item["F_Id"]);
        }
    }

    private function getPageTotal ($path)
    {
        // 打开文件
        if (!$fp = @fopen($path, "r")) {
            $error = "打开文件{$path}失败";
            return false;
        } else {
            $max = 0;
            while (!feof($fp)) {
                $line = fgets($fp, 255);
                if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                    preg_match('/[0-9]+/', $matches[0], $matches2);
                    if ($max < $matches2[0]) $max = $matches2[0];
                }
            }
            fclose($fp);
            // 返回页数
            return $max;
        }
    }
}