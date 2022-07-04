<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class BaseModel extends Model
{
    protected static $instance;//子类也需要有此静态变量

    /** 获取单例
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance) || !static::$instance instanceof static) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}
