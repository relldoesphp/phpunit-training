<?php
/**
 * File: src/HelloWorldTest.php
 */
namespace In2it\Phpunit;

class HelloWorld
{
    public function sayHello($argument = 'World')
    {
        return 'Hello ' . $argument . '!';
    }
}