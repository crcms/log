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
    public function create(Model $model,string $remark = '')
    {
        $user = $this->getUser();

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