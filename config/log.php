<?php
return [
    'log_model'=>[

        \CrCms\Log\Observers\BehaviorObserver::class=>[
            //Namespace\Model
        ]
    ],

    'user_session_key'=>[

    ],

    //'debug','info','warning','danger','error'
    'log_level'=>'info',
];