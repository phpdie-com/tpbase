<?php

namespace app\controller;

use app\BaseController;
use app\business\LogHelper;
use think\facade\Db;
use app\model\User;

class Index extends BaseController
{
    public function index()
    {
        $user = User::find(2);
        $user->name = 'thinkphp1122';
        $user->age = 22;
        $user->allowField(['name'])->save();
    }

    public function index1()//一对一 关联修改记录
    {
        echo 3 / 0;
        exit;
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
        $find = User::find(1);
        return json(['message' => 'success', 'code' => 200, 'data' => $find]);
    }

    public function demo5() //测试异常处理
    {
//        $find = User::cache(60)->find(1);
        $find = Db::name('user')->find(1);
        halt($find);
    }

    public function demo6()
    {
        Db::event('baozha', function () {
            echo 'hehe beng!';
        });
        Db::trigger('baozha');
    }

    public function demo7()//自动识别是插入还是更新，$data里要包含主键字段
    {
        $data = ['name' => input('name', 'zhangsan')];
        if (input('id')) $data['id'] = input('id');
        Db::name('user')->save($data);//不能用模型方法 模型方法会调用Model类里面的save方法，必须用db方法才会返回Query对象
    }

    public function demo8()//存在即更新,这里的name要设置为唯一索引
    {
        $insert = ['name' => 'zhangwuji'];
        $existsUpdate = ['name' => '张无忌'];//如果要插入的$insert存在于数据库则用$existsUpdate更新
        $result = Db::name('user')->duplicate($existsUpdate)->insert($insert);
        if ($result === 1) {
            echo '不存在插入成功';
        }
        if ($result === 2) {
            echo '更新成功返回';
        }
        print_r($result);
    }

    public function demo9()//自动写入时间.要用save方法才有效果 Db的insert和模型的insert不起作用   datebase.php修改 'auto_timestamp'  => 'timestamp',
    {
        $user = new User();
        $user->name = 'thinkphp';
        $user->save();
    }

    public function demo10()//存在即更新，会根据主键查找，如果数据库不存在则会插入记录，存在会更新 。官方推荐的最佳更新方式
    {
        $user = User::find(2);
        $user->name = 'thinkphp';
        $user->age = 110;
        $user->allowField(['name'])->save();//只允许name字段被更新 当然如果设置了自动写入时间字段，时间更新字段还是能更新到的
    }
}
