<?php
namespace CrCms\Log\Providers;

use CrCms\Log\Observers\BehaviorObserver;
use CrCms\Repository\RepositoryServiceProvider;
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
        //register serviceProviders
        //$this->app->register(RepositoryServiceProvider::class);

        //合并 config
        $this->mergeConfigFrom($this->configPath, 'log');
    }


    /**
     * 模型日志监听
     */
    protected function listenModel()
    {
        $observers = $this->app['config']['log']['log_model'];

        array_walk($observers,function($models,$observer){
            array_map(function($model) use ($observer){
                $model::observe($observer);
            },$models);
        });
    }
}