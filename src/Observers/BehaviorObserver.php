<?php
namespace CrCms\Log\Observers;

use CrCms\Log\Services\BehaviorLogService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BehaviorObserver
 * @package CrCms\Log\Observers
 */
class BehaviorObserver
{

    /**
     * @var BehaviorLogService|null
     */
    protected $service = null;


    /**
     * BehaviorObserver constructor.
     * @param BehaviorLogService $service
     */
    public function __construct(BehaviorLogService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Model $model
     */
    public function saved(Model $model)
    {
        $this->service->setLogType('info')
                    ->setLogModel($model)
                    ->setLogRemark('system observer listen')
                    ->setLogStatus(config('log.log_status.system'))
                    ->save();
    }

}