<?php
declare (strict_types=1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Score extends BaseModel
{
    public function getScoreAttr($value)
    {
        if (empty($value)) return '缺考';
        return $value >= 60 ? '及格' : '不及格';
    }
}
