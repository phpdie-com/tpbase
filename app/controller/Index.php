<?php

namespace app\controller;

use app\BaseController;
use app\business\LogHelper;
use app\model\User;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
    }

    public function index1()//一对一 关联修改记录
    {
        echo 3 / 0;
        exit;
//CREATE TABLE `t_user` (
//  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `name` varchar(255) DEFAULT NULL,
//  `age` int(11) DEFAULT NULL,
//  `sex` varchar(255) DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;

//CREATE TABLE `t_score` (
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

    public function demo7()//自动识别是插入还是更新，$data里有主键 就是更新 没有就是插入
    {
        $data = ['name' => input('name', 'zhangsan')];
        if (input('id')) $data['id'] = input('id');
        Db::name('user')->save($data);//不能用模型方法 模型方法会调用Model类里面的save方法，会报主键重复的错误，必须用db方法才会返回Query对象
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

    public function demo10()//最佳更新方法。 会根据主键查找，如果数据库不存在则会插入记录，存在会更新 。官方推荐的最佳更新方式
    {
        //单条记录更新
        $user = User::find(2);
        $user->name = 'thinkphp';
        $user->age = 110;
        $user->allowField(['name'])->save();//只允许name字段被更新 当然如果设置了自动写入时间字段，时间更新字段还是能更新到的
        //批量更新
        $user = new User;
        $list = [
            ['id' => 1, 'name' => 'thinkphp', 'age' => 12],
            ['id' => 2, 'name' => 'onethink', 'age' => 12]
        ];
        $user->saveAll($list);//批量更新仅能根据主键值进行更新，其它情况请自行处理。
        //静态方法更新数据
        $set = ['name' => 'aa'];
        $where = [['id', '>', 2]];
        $user = User::update($set, $where);
    }

    public function demo11()//最佳写入方法。 saveAll方法新增数据返回的是包含新增模型（带自增ID）的数据集对象
    {
        //单条记录写入
        $user = User::create([
            'name' => 'thinkphp',
            'age' => 20
        ]);
        echo $user->id; // 获取自增ID
        //批量写入
        $user = new User;
        $list = [
            ['name' => 'thinkphp', 'age' => 12],
            ['name' => 'onethink', 'age' => 13]
        ];
        $result = $user->saveAll($list);
        halt($result->toArray());
    }

    public function demo12()//软删除
    {
        User::destroy(13);
        $result = User::find(13);//不能查到
        //$result = Db::name('user')->where('id', 13)->find();//能查到
        //dump($result);

        //查出包含软删除的记录
        $result1 = User::withTrashed()->find(13);
        $result2 = User::withTrashed()->select();
        //dump($result1);

        //仅仅查询软删除的记录
        $result3 = User::onlyTrashed()->find(13);
        $result4 = User::onlyTrashed()->select();
        //dump($result4);

        //恢复被软删除的数据
        $user = User::onlyTrashed()->find(13);//不能用select，不能恢复一个列表，只能恢复一条
        $user->restore();
    }

    public function demo13()//查询到数据并插入到表
    {
        $insertField = ['name', 'age', 'sex'];//插入的字段名
        $queryField = "'" . implode(',', $insertField) . "'";//查询的字段
        $insertTable = 't_user';
        User::getInstance()->field($queryField)->whereIn('id', [2, 3])->selectInsert($insertField, $insertTable);
    }

    public function demo14()//模型属性的运用
    {
        $result = User::where('id', '>', 2)->withAttr('sex', function ($sex) {
            if ($sex == 1) return '男';
            if ($sex == 2) return '女';
            return '保密';
        })->select()->toArray();
        halt($result);

//        下面两个结果是等效的，不过还是觉得with好用一些
//        $result = User::whereIn('id', [2, 3])->append(['fenshu.score'])->select()->toArray();
//        $result = User::whereIn('id', [2, 3])->with(['fenshu'])->select()->toArray();
//        halt($result);
    }
}
