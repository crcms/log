<?php
namespace CrCms\Log\Repositories;

use CrCms\Log\Models\Behavior;
use CrCms\Repository\Eloquent\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BehaviorRepository
 * @package CrCms\Log\Repositories
 */
class BehaviorRepository extends AbstractRepository
{

    /**
     * @return Model
     */
    public function newModel(): Model
    {
        return app(Behavior::class);
    }

}