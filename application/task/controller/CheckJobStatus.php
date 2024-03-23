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
        redis()->setex($lockKey,'3600',1);
        $id = 0;
        $limit = 1000;
        do {
            $list = Db::name('voice_prctice')
                ->where('id', '>', $id)
                ->where('status', '=', '0')
                ->order('id', 'asc')
                ->limit($limit)
                ->select();
            $num = count($list);
            if ($num > 0) {
                $api_key = (new Config())->getVal('voice_api_key');
                foreach ($list as $i => $item) {
                    $id = $item['id'];
                    try {
                        if (empty($item['task_id'])) {
                            $data = [];
                            $api_key = (new Config())->getVal('voice_api_key');
                            if(empty($item['file_id'])){
                                $filePath = explode(',', $item['file_path_image']);
                                $file = [];
                                foreach ($filePath as $path) {
                                    $file[] = ROOT_PATH . '/public/' . $path;
                                }
                                $data['file_id'] = add_voice_file($api_key, $file);
                            }else{
                                $data['file_id'] = explode(',', $item['file_id']);
                            }

                            if (!empty($data['file_id'])) {
                                $data['task_id'] = add_voice_task($api_key, $data['file_id'], $item['finetuned_output']);
                                $data['file_id'] = implode(',', $data['file_id']);
                            } else {
                                $data['task_id'] = '';
                            }
                            Db::name('voice_prctice')->where('id', $id)->update($data);
                        } else {
                            $finetuned_output = check_job_status($api_key, $item['task_id']);
                            if ($finetuned_output) {
                                Db::name('voice_prctice')->where('id', $id)->update(['finetuned_output' => $finetuned_output, 'status' => 1]);
                            }
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