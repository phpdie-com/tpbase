<?php

class test
{
    private static $p3 = "world";
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
//var_dump($constructorName);//获取构造函数
$parameters = $constructorName->getParameters();
//var_dump($parameters);//获取构造函数参数

$methods = $class->getMethods();
//var_dump($methods);//获取所有成员函数，包含私有的方法
$attr = $class->getProperties();
//var_dump($attr);//获取所有成员属性，包含私有的属性
$attr_value = $class->getProperty('p1');
//var_dump($attr_value);//获取具体的成员属性值和属性名(非静态属性并没有提供根据数据名获取属性值的方法)
$attr_static = $class->getStaticProperties();
//var_dump($attr_static);//获取静态属性
$attr_static_value = $class->getStaticPropertyValue('p3');
//var_dump($attr_static_value);//获取具体的静态属性值
