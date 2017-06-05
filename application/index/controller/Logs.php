<?php
/**
 * Created by PhpStorm.
 * User: wanqianjun
 * Date: 2017/6/6
 * Time: 上午1:12
 */

namespace app\index\controller;

use think\Log;

class Logs
{
    public function Index ()
    {
     Log::record('111','error');
    }
}