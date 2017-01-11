<?php
namespace CrCms\Log\Services;

use CrCms\Log\Repositories\BehaviorRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

/**
 * Class BehaviorLogService
 * @package CrCms\Log\Services
 */
class BehaviorLogService
{

    /**
     * @var Request|null
     */
    protected $request = null;

    /**
     * @var Agent|null
     */
    protected $agent = null;

    /**
     * @var BehaviorRepository|null
     */
    protected $repository = null;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $logType = '';

    /**
     * @var string
     */
    protected $logStatus = '';

    /**
     * @var string
     */
    protected $logRemark = '';

    /**
     * @var null
     */
    protected $logModel = null;


    /**
     * BehaviorLogService constructor.
     * @param Request $request
     * @param Agent $agent
     * @param BehaviorRepository $repository
     */
    public function __construct(Request $request, Agent $agent, BehaviorRepository $repository)
    {
        $this->request = $request;
        $this->agent = $agent;
        $this->repository = $repository;
    }


    /**
     * @param string $logType
     */
    public function setLogType(string $logType) : self
    {
        if (!in_array($logType,config('log.log_levels'),true)) {
             throw new \Exception('log type error');
        }
        $this->logType = $logType;
        return $this;
    }


    /**
     * @param string $logStatus
     */
    public function setLogStatus(string $logStatus) : self
    {
        $this->logStatus = config('log.log_status')[$logStatus] ?? $logStatus;
        return $this;
    }


    /**
     * @param string $logRemark
     */
    public function setLogRemark(string $logRemark) : self
    {
        $this->logRemark = $logRemark;
        return $this;
    }


    /**
     * @param null $model
     * @return BehaviorLogService
     */
    public function setLogModel($model = null) : self
    {
        $this->logModel = $model;
        return $this;
    }


    /**
     * @return \CrCms\Log\Models\Behavior|null
     */
    public function save()
    {
        $this->setRequestData()
            ->setAgentData()
            ->setModelData()
            ->setUserData()
            ->setRemarkData()
            ->setTypeData()
            ->setStatusData();

        return $this->repository->create($this->data);
    }


    /**
     * @return BehaviorLogService
     */
    protected function setRemarkData() : self
    {
        $this->data['remark'] = $this->logRemark;
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setTypeData() : self
    {
        $this->data['log_type'] = empty($this->logType) ?
            config('log.default_level') : $this->logType;
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setModelData() : self
    {
        if ($this->logModel instanceof Model) {
            $this->data['model'] = serialize($this->logModel);
            $this->data['type'] = get_class($this->logModel);
            $this->data['type_id'] = $this->logModel->{$this->logModel->getKeyName()};
        } else {
            $this->data['model'] = (string)$this->logModel;
            $this->data['type'] = (string)$this->logModel;
            $this->data['type_id'] = 0;
        }
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setStatusData() : self
    {
        $this->data['status_message'] = empty($this->logStatus) ?
            config('log.default_status') : $this->logStatus;

        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setUserData() : self
    {
        $user = $this->getUser();
        $this->data['user_type'] = $user ? get_class($this->getUser()) : '';
        $this->data['user_id'] = $this->getUserId();
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setRequestData() : self
    {
        $this->data['client_ip'] = sprintf("%u",ip2long($this->request->ip()));
        $this->data['url'] = $this->request->fullUrl();
        $this->data['method'] = $this->request->method();
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setAgentData() : self
    {
        $this->data['agent'] = $this->agent->getUserAgent();
        return $this;
    }


    /**
     * @return mixed|null
     */
    protected function getUser()
    {
        $user = null;

        $api = config('log.user_api');
        if ($api) {
            $user = call_user_func([app($api['class']),$api['method']]);
        }

        return $user;
    }


    /**
     * @return int
     */
    protected function getUserId() : int
    {
        $userId = 0;

        $user = $this->getUser();
        if ($user) {
            $userId = $user->{config('log.user_api.key')};
        }

        return $userId;
    }
}