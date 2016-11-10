<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/10
 * Time: 16:56
 */

namespace CrCms\Log\Drives;


use CrCms\Log\LogInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BehaviorLog implements LogInterface
{

    /**
     * @var Request|null
     */
    public $request = null;

    /**
     * @var Agent|null
     */
    public $agent = null;

    /**
     * @var Model|null
     */
    public $user = null;


    /**
     * BehaviorLog constructor.
     * @param Request $request
     * @param Agent $agent
     * @param Model $user
     */
    public function __construct(Request $request,Agent $agent,Model $user)
    {
        $this->request = $request;
        $this->agent = $agent;
        $this->user = $user;
    }

}