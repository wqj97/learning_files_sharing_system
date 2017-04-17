<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/14
 * Time: 下午1:21
 */

namespace app\admin\model\transfer;

use think\Db;

class Transfer
{

    public function transfer_unsolve_file()
    {
        $unsove_file_list = Db::query("SELECT F_Id FROM File WHERE F_transfer_url IS NULL");
        foreach ($unsove_file_list as $key => $item) {
            echo "\r\n\r\n\r\n\r\n\r\n\r\n\r\n$key / " . count($unsove_file_list) . "\r\nfile_Id: $item[F_Id]\r\n\r\n\r\n\r\n\r\n\r\n";
            $this->Transfer($item["F_Id"]);
        }
    }
    private function Transfer($file_id)
    {
        $server_file_url = Db::query("SELECT F_url,F_ext FROM File WHERE F_Id = ?", [$file_id])[0];
        if ($server_file_url["F_ext"] != "pdf" || $server_file_url["F_ext"] != "PDF") {
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