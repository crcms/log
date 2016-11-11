<?php

if (!function_exists('behavior_log'))
{
    function behavior_log(string $remark,\Illuminate\Database\Eloquent\Model $model)
    {
        app(\CrCms\Log\Repositories\BehaviorRepository::class)->create($model,$remark);
//        dispatch((new \CrCms\Log\Jobs\BehaviorLogJob($remark,$model))->onQueue('log'));
    }
}
