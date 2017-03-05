<?php
require 'Library/Di.php';
require 'Library/Foo.php';

$di = new Library\Di();

$di->set('foo', function () {
    $foo = new \Library\Foo();
    return $foo;
});
$di->set('foo2', new \Library\Foo()); //not recommend
$di->set('foo3', '\Library\Foo');
$di->set('foo4', \Library\Foo::class);
$di->setShared('foo5', '\Library\Foo');


echo $di->get('foo')->bar();
//init:foo

echo $di->get('foo2')->bar();
//init:foo

echo $di->get('foo3')->bar();
//init:foo

$foo4 = $di->get('foo4');
echo $foo4->bar();
//init:foo
$foo4->var = 'hello world';
echo $di->get('foo4')->bar();
//init:foo


$foo5 = $di->get('foo5');
echo $foo5->bar();
//init:foo
$foo5->var = 'hello world';
echo $di->get('foo5')->bar();
//hello world

echo $di->foo5->bar();//magic methods
//hello world