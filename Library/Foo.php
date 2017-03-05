<?php
namespace Library;

class Foo
{
    public $var = 'init:foo';

    public function __construct()
    {
        //echo 'init Foo' . PHP_EOL;
    }

    public function bar()
    {
        return $this->var . PHP_EOL;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }
}