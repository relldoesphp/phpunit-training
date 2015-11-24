<?php
/**
 * File: tests/ModuleManagerTest.php
 */
class ModuleManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnImmediatelyWhenModuleAlreadyLoaded()
    {
        $module = 'Foo_Bar';
        ModuleManager::$modules_install[$module] = 1;
        $result = ModuleManager::include_install($module);
        $this->assertTrue($result);
        $this->assertCount(1, ModuleManager::$modules_install);
    }
}
