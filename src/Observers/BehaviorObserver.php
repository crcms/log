<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/11
 * Time: 10:42
 */

namespace CrCms\Log\Observers;


use CrCms\Log\Repositories\BehaviorRepository;
use Illuminate\Database\Eloquent\Model;

class BehaviorObserver
{

    /**
     * @var BehaviorRepository|null
     */
    protected $repository = null;

    /**
     * BehaviorObserver constructor.
     * @param BehaviorRepository $repository
     */
    public function __construct(BehaviorRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param Model $model
     */
    public function saved(Model $model)
    {
        $this->repository->create($model);
    }

}