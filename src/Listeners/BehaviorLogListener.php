<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/11
 * Time: 9:15
 */

namespace CrCms\Log\Listeners;


use CrCms\Log\Events\BehaviorLogEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BehaviorLogListener implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * @param BehaviorLogEvent $event
     */
    public function handle(BehaviorLogEvent $event)
    {
//        $event->repository->create(new Category,'aaaaaaaaaa');
    }

}