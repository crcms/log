<?php
namespace CrCms\Log\Services;

use CrCms\Log\Jobs\BehaviorLogJob;
use CrCms\Log\Models\Behavior;
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
     * @var Behavior|null
     */
    protected $model = null;

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
     */
    public function __construct(Request $request, Agent $agent, Behavior $model)
    {
        $this->request = $request;
        $this->agent = $agent;
        $this->model = $model;
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
            ->setLogTime()
            ->setStatusData();

        if (config('log.open_queue')) {
            return dispatch(
                (new BehaviorLogJob($this->data))->onQueue(config('log.queue_name'))
            );
        } else {
            return $this->model->create($this->data);
        }
    }


    /**
     * @return BehaviorLogService
     */
    protected function setLogTime() : self
    {
        $this->data['created_at'] = date('Y-m-d H:i:s');
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setRemarkData() : self
    {
        $this->data['remark'] = (string)$this->logRemark;
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
            $this->data['type_id'] = $this->logModel->{$this->logModel->getKeyName()} ?? 0;
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
        $ip = $this->request->ip()==='::1' ? '127.0.0.1' : $this->request->ip();
        $this->data['client_ip'] = sprintf("%u",ip2long($ip));
        $this->data['url'] = (string)$this->request->fullUrl();
        $this->data['method'] = (string)$this->request->method();
        return $this;
    }


    /**
     * @return BehaviorLogService
     */
    protected function setAgentData() : self
    {
        $this->data['agent'] = (string)$this->agent->getUserAgent();
        return $this;
    }


    /**
     * @return mixed|null
     */
    protected function getUser()
    {
        $user = null;

        $api = config('log.user_api');
        if (!empty($api['class']) && !empty($api['method'])) {
            $user = call_user_func([app($api['class']),$api['method']]);
        }

        //cove object
        if (is_array($user)) {
            $user = json_decode(json_encode($user));
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