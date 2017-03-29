<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/3/28
 * Time: 下午3:49
 */

namespace app\file\controller;

use think\Db;

class Upload
{
    /**
     * 文件上传
     * step1: 移动文件
     * step2: 检查文件是否重复
     * step3: 更新数据库, 返回结果, 更新用户数据
     * @return \think\response\Json
     */
    public function Index()
    {
        $this->addScore();
        $file = request()->file('file');
        $info = $file->move($_SERVER['DOCUMENT_ROOT'] . '/upload');
        $file_ext = $info->getExtension();
        if (!$this->checkExt($file_ext)) {
            unlink($info->getRealPath());
            return json(["result" => "failed", "reason" => "$file_ext 是不允许的文件格式"],403);
        }
        $file_hash = md5_file($info->getRealPath());
        $hashInDb = Db::query("SELECT * FROM File WHERE F_hash = ?", [$file_hash]);
        if (!empty($hashInDb)) {
            unlink($info->getRealPath());
            return json(["result" => "failed", "reason" => "文件已存在"],403);
        }
        $file_name = $info->getInfo()['name'];
        $file_src = '/upload/' . date('Ymd') . "/" . $file_name;
        Db::execute('INSERT INTO File (F_name,F_hash,F_url,F_ext,F_user_openid) VALUES (?,?,?,?,?)', [$file_name, $file_hash, $file_src, $file_ext, cookie('openid')]);
        return json(["result" => "success", "file_info" => ["file_name" => $file_name, "file_ext" => $file_ext]]);
    }

    /**
     * 检查MD5是否已经存在
     * @get String md5
     * @return \think\response\Json
     */
    public function check()
    {
        $hash = input('get.hash');
        $hashInDb = Db::query('SELECT * FROM File WHERE F_hash = ?', [$hash]);
        if (empty($hashInDb)) {
            return json(['result' => 'success']);
        }
    }

    /**
     * 文件类型支持检查器
     * @param $ext String 扩展名
     * @return bool 是否存在允许的扩展名
     */
    private function checkExt($ext)
    {
        $ext = mb_strtolower($ext);
        $file_typs = config('file_types');
        foreach ($file_typs as $type) {
            if ($type == $ext) {
                return true;
            }
        }
        return false;
    }

    /**
     * 给上传的用户添加分数
     */
    private function addScore()
    {
        $openid = cookie('openid');
        $file_credit = (Int)Server_Setting('file_credit');
        Db::execute("update User set U_credit = U_credit + $file_credit where U_openid = '$openid'");
    }
}