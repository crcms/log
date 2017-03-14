<?php
namespace CrCms\Log\Jobs;

use CrCms\Log\Models\Behavior;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class BehaviorLogJob
 * @package CrCms\Log\Jobs
 */
class BehaviorLogJob implements ShouldQueue
{
    use  InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $tries = 3;

    /**
     * @var int
     */
    public $timeout = 5;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * BehaviorLogJob constructor.
     * @param Behavior $model
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Behavior $model)
    {
        $model->create($this->data);
    }
}
