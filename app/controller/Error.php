<?php
declare (strict_types=1);

namespace app\controller;

use think\Request;

class Error
{
    public function __call($method, $args)
    {
        return \think\facade\Request::controller() . '控制器不存在!';
    }
}
