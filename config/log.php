<?php
return [

    'log_model'=>[
        \CrCms\Log\Observers\BehaviorObserver::class=>[
            //Namespace\Model
        ]
    ],

    'log_levels'=>[
        'debug'=>'debug',
        'info'=>'info',
        'notice'=>'notice',
        'warning'=>'warning',
        'error'=>'error',
        'critical'=>'critical',
        'alert'=>'alert',
        'emergency'=>'emergency',
    ],

    'default_level'=>'info',


    'log_status'=>[
        'success'=>'success',
        'error'=>'error',
        'fail'=>'fail',
        'test'=>'test',
        'system'=>'system',
    ],


    'default_status'=>'success',

    'user_api'=>[
        'class'=>\App\Test::class,
        'method'=>'getUser',
        'key'=>'id'
    ],

];