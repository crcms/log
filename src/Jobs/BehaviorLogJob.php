<?php

namespace CrCms\Log\Jobs;

use CrCms\Category\Models\Category;
use CrCms\Log\Repositories\BehaviorRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BehaviorLogJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var null
     */
    protected $model = null;

    /**
     * @var string
     */
    protected $remark = '';

    public $repository = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
//    public function __construct(string $remark)
//    {
//        $this->remark = $remark;
////        $this->model = $model;
//    }

    public function __construct()
    {
        $this->repository = $repository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(BehaviorRepository $repository)
    {//BehaviorRepository $repository
        //
        $this->repository->create(new Category(),'afdasfdsafdsafdsa');
    }

}
