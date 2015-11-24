<?php
/**
 * File: tests/HelloWorldTest.php
 */
namespace In2it\Test\Phpunit;

use In2it\Phpunit\HelloWorld;

class HelloWorldTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodReturnsHelloWorld()
    {
        $helloWorld = new HelloWorld();
        $this->assertSame(
            'Hello World!',
            $helloWorld->sayHello()
        );
    }
}