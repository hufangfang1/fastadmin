<?php

namespace app\admin\controller\voice;

use app\common\controller\Backend;
use app\common\model\Config;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Prctice extends Backend
{

    /**
     * Prctice模型对象
     * @var \app\admin\model\voice\Prctice
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\voice\Prctice;
        $this->view->assign("statusList", $this->model->getStatusList());
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 添加
     *
     * @return string
     * @throws \think\Exception
     */
    public function add()
    {
        if (false === $this->request->isPost()) {
            return $this->view->fetch();
        }
        $params = $this->request->post('row/a');
        if (empty($params)) {
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $params = $this->preExcludeFields($params);

        if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
            $params[$this->dataLimitField] = $this->auth->id;
        }
        $result = false;
        Db::startTrans();
        try {
            //是否采用模型验证
            if ($this->modelValidate) {
                $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                $this->model->validateFailException()->validate($validate);
            }
            $api_key = (new Config())->getVal('voice_api_key');
            $filePath = explode(',',$params['file_path_image']);
            $file = [];
            foreach($filePath as $path){
                $file[] = ROOT_PATH . '/public/' . $params['file_path_image'];
            }
            $params['file_id'] = add_voice_file($api_key, $file);
            if (!$params['file_id']) {
                $params['task_id'] = add_voice_task($api_key, $params['file_id'], $params['finetuned_output']);
                $params['file_id'] = implode(',', $params['file_id']);
            } else {
                $params['task_id'] = '';
            }
            $params['update_time'] = time();
            $params['create_time'] = time();
            $result = $this->model->allowField(true)->save($params);
            Db::commit();
        } catch (ValidateException|PDOException|Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if ($result === false) {
            $this->error(__('No rows were inserted'));
        }
        $this->success();
    }


}
