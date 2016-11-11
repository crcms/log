<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/10
 * Time: 16:56
 */

namespace CrCms\Log\Events;


use CrCms\Log\LogInterface;
use Illuminate\Queue\SerializesModels;

class BehaviorLogEvent implements LogInterface
{

    use SerializesModels;

    public $model = null;

    public function __construct()
    {
    }
}