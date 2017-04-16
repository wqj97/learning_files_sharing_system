<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/4/14
 * Time: 下午1:21
 */

namespace app\file\controller;
require_once $_SERVER["DOCUMENT_ROOT"] . "/extend/pdf2image/vendor/autoload.php";
use think\Db;
use think\Exception;
use think\Debug;
use Spatie\PdfToImage;
class Transfer
{
    /**
     * 文件预览
     * @get file_id
     */
    public function Index()
    {
        ini_set("max_execution_time","3600");
        $file_id = input('get.file_id');
//        $file_url = $_SERVER["DOCUMENT_ROOT"].Db::query("select F_url from File where F_Id = ?",[$file_id])[0]["F_url"];
        $file_url = $_SERVER["DOCUMENT_ROOT"]."/upload/20170414/00297cb3176fa3b82d7d4449f681de88.pdf";
        $pdf = new PdfToImage\Pdf($file_url);
        $pdf->setOutputFormat('jpeg');
        $pdf->saveImage($file_url.'_1.jpg');
        $pdf->setPage(2);
        $pdf->saveImage($file_url.'_2.jpg');
        $pdf->setPage(3);
        $pdf->saveImage($file_url.'_3.jpg');
    }

}