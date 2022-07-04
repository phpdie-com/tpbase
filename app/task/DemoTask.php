<?php

namespace app\task;

use think\facade\Log;
use yunwuxin\cron\Task;

class DemoTask extends Task
{

    public function configure()
    {
        //$this->daily(); //设置任务的周期，每天执行一次，更多的方法可以查看源代码，都有注释
        $this->everyMinute();//每分钟执行
    }

    /**
     * 执行任务
     * @return mixed
     */
    protected function execute()
    {
//...具体的任务执行
        Log::write(date('Y-m-d ') . '执行了定时任务');
    }
}