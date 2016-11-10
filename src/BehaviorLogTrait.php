<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/10
 * Time: 16:57
 */

namespace CrCms\Log;


use CrCms\Log\Models\Behavior;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

trait BehaviorLogTrait
{

    /**
     * @param Request $request
     * @param Agent $agent
     * @param Model|null $user
     */
    public function behavior(Request $request,Agent $agent,Model $user = null)
    {
        static::saved(function(Model $model) use ($request,$agent,$user){
            Behavior::create([
                'client_ip'=>sprintf("%u",ip2long($request->ip())),
                'model'=>serialize($model),
                'url'=>$request->fullUrl(),
                'method'=>$request->method(),
                'agent'=>$agent->getUserAgent(),
                'user_id'=>$user ? $user->id : 0,
                'user_type'=>$user ? get_class($user) : '',
            ]);
        });
    }
}