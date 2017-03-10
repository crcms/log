# log

## log queue
php artisan queue:work --queue=behavior_log --timeout=5 --tries=3 --sleep=3 --daemon --quiet