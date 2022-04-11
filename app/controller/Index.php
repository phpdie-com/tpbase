<?php

namespace app\controller;

use app\BaseController;
use app\business\LogHelper;
use think\facade\Db;
use app\model\User;

class Index extends BaseController
{
    public function index()//一对一 关联修改记录
    {
//CREATE TABLE `user` (
//  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `name` varchar(255) DEFAULT NULL,
//  `age` int(11) DEFAULT NULL,
//  `sex` varchar(255) DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;

//CREATE TABLE `score` (
//    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `user_id` int(10) unsigned DEFAULT NULL,
//  `subject` varchar(255) DEFAULT NULL,
//  `score` int(10) unsigned DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        $user = User::find(1);
        $user->name = 'zhangsan';
        $user->chengji->score = '100';
        // 更新当前模型及关联模型
        $user->together(['chengji'])->save();

//        // 查询
//        $user = Blog::with('chengji')->find(1);
//        // 删除当前及关联模型
//        $user->together(['chengji'])->delete();
    }

    public function index2()//一对多 关联新增记录
    {
        $user = User::find(1);
        // 增加一个关联数据
        $user->fenshu()->save(['subject' => 'test2', 'score' => 10]);
        // 批量增加关联数据
        $user->fenshu()->saveAll([
            ['subject' => 'test3', 'score' => 30],
            ['subject' => 'test4', 'score' => 40],
        ]);
    }

    public function index3()//一对多 关联删除记录
    {
        $user = User::with('fenshu')->find(1);
        $user->together(['fenshu'])->delete();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    public function demo1() //闭包的使用
    {
        $back = function () {
            return $this->name;
        };
        $log = new LogHelper();
        echo $log->show($back);
    }

    public function demo2() //闭包的使用
    {
        $back = function () {
            $this->name = 'lisi';
        };
        $log = new LogHelper();
        $new_fn = $back->bindTo($log);
        $new_fn(); //调用一下
        echo $log->out();
    }

    public function demo3() //闭包的使用
    {
        $log = new LogHelper();
        $log->ggg = 'ggg';
        halt($log);
    }

    public function demo4() //测试异常处理
    {
        $find=User::find(1);
        return json(['message'=>'success','code'=>200,'data'=>$find]);
    }
}
