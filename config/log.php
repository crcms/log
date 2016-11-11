<?php
return [
    'log_model'=>[

        \CrCms\Log\Observers\BehaviorObserver::class=>[
            \CrCms\Category\Models\Category::class,
        ]


    ],
    'user_session_key'=>[
        'manage_session','user_session'
    ]
];