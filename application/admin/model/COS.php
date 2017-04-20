<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/20
 * Time: 上午11:41
 */

namespace app\admin\model;
//require_once $_SERVER["DOCUMENT_ROOT"] . "/extend/Tencent_COS_SDK/include.php";
require_once "/home/wwwroot/wx.97qingnian.com/extend/Tencent_COS_SDK/include.php";
use \qcloudcos\Cosapi;
use think\Debug;


class COS
{
    /**
     * 检查目录是否存在, 存在返回true, 不存在会创建一个目录, 然后返回结果
     * @param $folder_name |String 需要检查的目录名
     * @return bool
     */
    public function checkFolder ($folder_name)
    {
        $file_info = Cosapi::statFolder('aiuyi', $folder_name);
        if ($file_info["code"] != 0) {
            $file_info = $this->newFolder($folder_name);
        }
        if ($file_info["code"] == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 创建新的文件夹
     * @param $folder_name
     * @return array|mixed
     */
    public function newFolder ($folder_name)
    {
        $result = Cosapi::createFolder('aiuyi', $folder_name);
        return $result;
    }

    /**
     * 上传文件
     * @param $file_path String 本地文件路径
     * @param $folder_name String 远程文件路径
     * @return array|mixed 返回处理结果
     */
    public function upLoad ($file_path,$folder_name)
    {
        $result = Cosapi::upload('aiuyi',$file_path,$folder_name);
        return $result;
    }

    /**
     * 删除COS上的文件
     * @param $file_path
     * @return array|mixed
     */
    public function delete ($file_path)
    {
        $file_path = str_replace("http://aiuyi-1253584494.file.myqcloud.com","",$file_path);
        $result = Cosapi::delFile('aiuyi',$file_path);
        return $result;
    }
}