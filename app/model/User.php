<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class User extends Model
{
    public function chengji()
    {
        return $this->hasOne(Score::class);
    }

    public function fenshu()
    {
        return $this->hasMany(Score::class);
    }
}
