<?php

namespace app\task\controller;

use app\common\model\Config;
use think\Db;
use app\api\library\ComErrorDescs;

class CheckJobStatus extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        set_time_limit(0);
    }

    public function index()
    {
        $lockKey = 'check_job_status';
        $lock = redis()->get($lockKey);
        if ($lock) {
            exit('任务正在执行中');
        }
        $id = 0;
        $limit = 1000;
        do {
            $list = Db::name('voice_prctice')
                ->where('id', '>', $id)
                ->where('status', '=', '0')
                ->where('task_id', '<>', '')
                ->order('id', 'asc')
                ->limit($limit)
                ->select();
            $num = count($list);
            if ($num > 0) {
                $api_key = (new Config())->getVal('voice_api_key');
                foreach ($list as $i => $item) {
                    $id = $item['id'];
                    try {
                        $finetuned_output = check_job_status($api_key, $item['task_id']);
                        if ($finetuned_output) {
                            Db::name('voice_prctice')->where('id', $id)->update(['finetuned_output' => $finetuned_output, 'status' => 1]);
                        }
                    } catch (\Exception $e) {
                        var_dump($e->getLine() . ':' . $e->getMessage());
                        continue;
                    }
                }
            }
        } while ($num >= $limit);
        redis()->del($lockKey);
        $this->render();
    }
}