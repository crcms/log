<?php
namespace CrCms\Log\Models;

use Illuminate\Database\Eloquent\Model;

class Behavior extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 不允许写入的字段，默认解除禁止
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = 'behavior_logs';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOneUser()
    {
        if ($this->attributes['user_type'] && class_exists($this->attributes['user_type'])) {
            return $this->hasOne($this->attributes['user_type'],'id','user_id');
        }
        return null;
    }

}