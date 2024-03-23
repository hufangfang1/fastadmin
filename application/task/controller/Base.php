<?php

namespace app\task\controller;

use app\api\library\ComErrorDescs;
use think\Controller;
use think\Request;
use think\Session;

/**
 * Class Base [脚本基类]
 * Auther Changzd
 * @package app\task\controller
 */
class Base extends Controller
{
    public function _initialize()
    {
        Session::set('task_start_time', microtime(true));
        Session::set('task_start_memory', memory_get_usage());
        set_time_limit(0);
        set_exception_handler(array($this, 'taskError'));
        if (!$this->request->isCli()) {
            $this->render(ComErrorDescs::EC_CLI_ONLY, '', ComErrorDescs::errmsg(ComErrorDescs::EC_CLI_ONLY));
        }
    }

    public function render($errno = 0, $data = [], $msg = '')
    {
        $data = [
            '时间：' . date('Y-m-d H:i:s') . '. 命令：[' . implode(' ', $_SERVER['argv'] ?? []) . ']',
            '执行时长：' . (microtime(true) - Session::get('task_start_time')) . 's',
            '使用内存：' . $this->memConvert(memory_get_usage() - Session::get('task_start_memory')),
            "状态码:：" . $errno,
            "数据内容:" . json_encode_cus($data),
            "提示信息:" . $msg,
        ];

        echo str_pad('', 63, '-') . "\n";
        echo implode("\n", $data);
        echo "\n";
        exit;
    }

    /**
     * Function taskError [错误记录]
     * Auther: Changzd
     * Date: 2020-10-28
     * @param $exception
     */
    public function taskError($exception)
    {
        $errno = $exception->getCode();
        $msg   = $exception->getMessage();

        $errmsg = 'Error:' . $msg . "\n";
        //$errmsg.= $exception->getTraceAsString()."\n";
        $errmsg .= '异常行号：' . $exception->getLine() . "\n";
        $errmsg .= '所在文件：' . $exception->getFile() . "\n";

        if (0 === $errno) {//抛出未知错误
            $errno = ComErrorDescs::EC_UNKNOWN;
        }
        $comErrno = $errno . ',' . $msg;
        $errmsg   = ComErrorDescs::errmsg($comErrno, $errmsg);

        $this->render($errno, '', $errmsg);
    }

    /**
     * Function memConvert [内存转换]
     * Auther: Changzd
     * Date: 2020-10-28
     * @param $size
     * @return string
     */
    function memConvert($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    /**
     * Notes: 脚本执行进度条
     * User: hufangfang
     * DateTime: 2022/1/7 下午2:19
     * @param $i 当前执行到
     * @param $dataCount 执行总数
     */
    public function process($i, $total, $k, $dataCount)
    {
        $totalLen = 50;       //默认进度条的长度
        $baseNum = 100;        //百分比进制
        $ratio = bcmul(bcdiv($k, $dataCount, 2), $baseNum);                       //计算当前执行位置在总循环次数的占比
        $speedLen = ceil(bcmul($totalLen, bcdiv($ratio, $baseNum, 2)));           //然后乘以总长度得出当前进度条显示长度
        $spaceLen = $totalLen - $speedLen;
        echo '总共' . $total . '个_当前第' . $i . '个[' . str_repeat('#', $speedLen) . str_repeat(' ', $spaceLen) . ']' . $ratio . '%' . "\r";
    }
}