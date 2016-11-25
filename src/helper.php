<?php

if (!function_exists('behavior_log'))
{
    function behavior_log(string $remark,$model = null,string $logType = \CrCms\Log\Repositories\BehaviorRepository::LOG_TYPE_INFO)
    {
        app(\CrCms\Log\Repositories\BehaviorRepository::class)->create($remark,$model,$logType);
    }
}
