<?php

namespace app\business;

class LogHelper
{
    public $name = 'hello';

    public function show(\Closure $call)//这里的\Closure也可以换成callable
    {
        return call_user_func($call->bindTo($this));
    }

    public function out()
    {
        echo $this->name;
    }
}