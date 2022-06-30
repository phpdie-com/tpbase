<?php
declare (strict_types=1);

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin Model
 */
class User extends BaseModel
{
    use SoftDelete;

    public function chengji()
    {
        return $this->hasOne(Score::class);
    }

    public function fenshu()
    {
        return $this->hasMany(Score::class);
    }
}
