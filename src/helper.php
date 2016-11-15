<?php

if (!function_exists('behavior_log'))
{
    function behavior_log(string $remark,\Illuminate\Database\Eloquent\Model $model,string $logType = \CrCms\Log\Repositories\BehaviorRepository::LOG_TYPE_INFO)
    {
        app(\CrCms\Log\Repositories\BehaviorRepository::class)->create($model,$logType,$remark);
//        dispatch((new \CrCms\Log\Jobs\BehaviorLogJob($remark,$model))->onQueue('log'));
    }
}
