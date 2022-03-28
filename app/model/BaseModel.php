<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class BaseModel extends Model
{
    protected static $instance;

    /** 获取单例
     * @return static
     */
    public static function getInstance()
    {
        if (static::$instance) {
            return static::$instance;
        }
        return new static();
    }
}
