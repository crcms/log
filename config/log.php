<?php
return [

    'log_model'=>[
        \CrCms\Log\Observers\BehaviorObserver::class=>[
            //Namespace\Model
        ]
    ],

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
        'class'=>'',//Examples : App\Services\Test::class
        'method'=>'getUser',
        'key'=>'id'
    ],

];