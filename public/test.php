<?php

class test
{
    private $p1 = "123";
    private $p2 = "hello";

    private function __construct($a, $b)
    {
        echo $a, $b;
    }

    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test)
    {
        $this->test = $test;
        return $this;
    }

    private function my()
    {
        echo '私有方法';
    }
}

$class = new ReflectionClass('test');
$className = $class->getName();
//var_dump($className);//获取类名
//if (!$class->isInstantiable()) {
//    echo sprintf("%s不能被实例化", $class);
//} else {
//    echo sprintf("%s能被实例化", $class);
//}
$constructorName = $class->getConstructor();
var_dump($constructorName);//获取构造函数
$parameters = $constructorName->getParameters();
var_dump($parameters);//获取构造函数参数

$methods = $class->getMethods();
//var_dump($methods);//获取所有成员函数，包含私有的方法
$attr = $class->getProperties();
//var_dump($attr);//获取所有成员属性，包含私有的属性