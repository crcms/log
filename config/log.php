<?php
return [

    //自动监听的日志模型
    'log_model'=>[
        \CrCms\Log\Observers\BehaviorObserver::class=>[
            //Namespace\Model
        ]
    ],

    //日志等级
    'log_levels'=>[
        'debug',
        'info',
        'notice',
        'warning',
        'error',
        'critical',
        'alert',
        'emergency',
    ],

    'default_level'=>'info',//默认日志等级

    //日志状态
    'log_status'=>[
        'success'=>'success',
        'error'=>'error',
        'fail'=>'fail',
        'test'=>'test',
        'system'=>'system',
    ],

    'default_status'=>'success',//默认日志状态

    'log_module'=>[],//日志模块

    'user_api'=>[//user api中获取user的id
        'class'=>'',//Examples : App\Services\Test::class
        'method'=>'getUser',
        'key'=>'id'
    ],

    'open_queue'=>false,//是否开启队列记录日志
    'queue_name'=>'behavior_log',//日志队列名称
];