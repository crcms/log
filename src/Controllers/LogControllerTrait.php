<?php
namespace CrCms\Log\Controllers;

trait LogControllerTrait
{
    /**
     * @param string $remark
     * @param null $model
     * @param string $type
     */
    protected function log(string $remark,$model = null,$type = 'info',$status = 'success')
    {
        return behavior_log($remark,$model,$status,$type);
    }
}