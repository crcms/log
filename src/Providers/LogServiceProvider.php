<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/10
 * Time: 16:53
 */

namespace CrCms\Log\Providers;


use CrCms\Log\Observers\BehaviorObserver;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $configPath = __DIR__.'/../../config/log.php';

    /**
     * @var string
     */
    protected $migrationPath = __DIR__.'/../../database';


    /**
     *
     */
    public function boot()
    {
        $this->loadMigrationsFrom($this->migrationPath);

        $this->publishes([
            $this->configPath => config_path('log.php'),
            $this->migrationPath => database_path('migrations')
        ]);

        //
        $this->listenModel();
    }


    /**
     *
     */
    public function register()
    {
        //合并 config
        $this->mergeConfigFrom($this->configPath, 'log');
    }


    /**
     * 模型日志监听
     */
    protected function listenModel()
    {
        $observers = $this->app['config']['log']['log_model'];
        foreach ($observers as $observer)
        {
            foreach ($observer as $model)
            {
                $model::observe(BehaviorObserver::class);
            }
        }
    }
}