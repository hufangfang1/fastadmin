<?php


namespace app\task\controller;

use app\common\model\Config;
use think\Db;
use app\api\library\ComErrorDescs;

class Test extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        set_time_limit(0);
    }

    public function index()
    {
        $text = '你好世界';
//        $path = text_to_voice($text,'sk-eae91e0787bf4e80b84c0140bc7ca50e','sambert-zhichu-v1');
        $path = text_to_voice($text,'sk-2f7802dd297c4beb92d7a88645532214','sambert-mengmimian-ft-202403232341-b9a0');
        var_dump($path);
        $this->render();
    }
}