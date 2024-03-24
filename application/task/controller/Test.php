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
        $text = '文章讨论了不同时代人们的生活方式和消费观念差异，以及节俭的重要性。老一辈人经历过物质匮乏，注重节俭；现代人追求精神满足和个性展示，但易过度消费。支付方式也影响消费习惯，现金支付有实在感，手机支付则易放松警惕。理解和尊重不同生活方式，才能促进家庭和谐。';
        text_to_voice($text,'sk-eae91e0787bf4e80b84c0140bc7ca50e','sambert-zhichu-v1');
        $this->render();
    }
}