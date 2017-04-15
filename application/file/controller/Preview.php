<?php
///**
// * Created by PhpStorm.
// * User: wanqianjun
// * Date: 2017/4/14
// * Time: 下午1:21
// */
//
//namespace app\file\controller;
//require_once $_SERVER["DOCUMENT_ROOT"] . "/extend/phpword/vendor/autoload.php";
//use \PhpOffice\PhpWord;
//use think\Exception;
//
//class Preview
//{
//    /**
//     * 文件预览
//     * @get file_id
//     */
//    public function Index()
//    {
//        $file_id = input('get.file_id');
//        PhpWord\Settings::loadConfig();
//        $phpWord = PhpWord\IOFactory::load($_SERVER["DOCUMENT_ROOT"] . "/upload/20170411/Phpwordtest.docx");
//        try {
//            $phpWord->save($_SERVER["DOCUMENT_ROOT"] . "/upload/20170411/Phpwordtest.pdf","PDF");
//        } catch (Exception $e) {}
//    }
//
//}