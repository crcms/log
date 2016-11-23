<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2016/11/10
 * Time: 17:02
 */

namespace CrCms\Log\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Behavior extends Model
{

//    use SoftDeletes;

    /**
     * 不允许写入的字段，默认解除禁止
     * @var array
     */
    protected $guarded = [];

    /**
     * 软删除
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $table = 'behavior_logs';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOneUser()
    {
        if ($this->attributes['user_type'] && class_exists($this->attributes['user_type']))
        {
            return $this->hasOne($this->attributes['user_type'],'id','user_id');
        }
        return null;
    }

}