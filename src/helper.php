<?php

if (!function_exists('behavior_log'))
{
    function behavior_log(string $remark,$model = null,string $status = '',string $logType = 'info')
    {
        app(CrCms\Log\Services\BehaviorLogService::class)
        ->setLogType($logType)
        ->setLogModel($model)
        ->setLogRemark($remark)
        ->setLogStatus($status)
        ->save();
    }
}
