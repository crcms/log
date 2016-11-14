<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/11
 * Time: 14:02
 */

namespace CrCms\Log\Repositories;


use CrCms\Log\Models\Behavior;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BehaviorRepository
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
     *
     */
    const LOG_TYPE_DEBUG = 'debug';

    /**
     *
     */
    const LOG_TYPE_INFO = 'info';

    /**
     *
     */
    const LOG_TYPE_WARNING = 'warning';

    /**
     *
     */
    const LOG_TYPE_DANGER = 'danger';

    /**
     *
     */
    const LOG_TYPE_ERROR = 'error';

    /**
     *
     */
    const LOG_TYPE = [self::LOG_TYPE_DEBUG,self::LOG_TYPE_INFO,self::LOG_TYPE_WARNING,self::LOG_TYPE_DANGER,self::LOG_TYPE_ERROR];

    /**
     * BehaviorRepository constructor.
     * @param Behavior $model
     * @param Request $request
     * @param Agent $agent
     */
    public function __construct(Behavior $model,Request $request,Agent $agent)
    {
        $this->model = $model;
        $this->request = $request;
        $this->agent = $agent;
    }


    /**
     * @param Model $model
     * @param Model|null $user
     * @param string $remark
     * @return Behavior|null
     */
    public function create(Model $model,string $logType = self::LOG_TYPE_INFO,string $remark = '')
    {
        //匹配记录等级
        $allowLevelKey = array_search(config('log.log_level'),static::LOG_TYPE);
        $currentLevel = array_search($logType,static::LOG_TYPE);
        if ($currentLevel < $allowLevelKey)
        {
            return null;
        }

        //get User
        $user = $this->getUser();

        //save
        $this->model->client_ip = sprintf("%u",ip2long($this->request->ip()));
        $this->model->model = serialize($model);
        $this->model->url = $this->request->fullUrl();
        $this->model->method = $this->request->method();
        $this->model->agent = $this->agent->getUserAgent();
        $this->model->user_id = $user ? $user->id : 0;
        $this->model->user_type = $user ? get_class($user) : '';
        $this->model->type = get_class($model);
        $this->model->type_id = $model->{$model->getKeyName()} ?? 0;
        $this->model->remark = $remark;
        $this->model->log_type = $logType;
        $this->model->save();

        return $this->model;
    }


    /**
     * @return mixed|null
     */
    protected function getUser()
    {
        foreach (config('log.user_session_key') as $key)
        {
            if (session()->has($key))
            {
                return session($key);
            }
        }

        return null;
    }
}