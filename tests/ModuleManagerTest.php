<?php
/**
 * File: tests/ModuleManagerTest.php
 */
class ModuleManagerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        ModuleManager::$modules_install = array ();
    }

    protected function tearDown()
    {
        ModuleManager::$modules_install = array ();
        parent::tearDown();
    }

    /**
     * @covers ModuleManager::include_install
     */
    public function testReturnImmediatelyWhenModuleAlreadyLoaded()
    {
        $module = 'Foo_Bar';
        ModuleManager::$modules_install[$module] = 1;
        $result = ModuleManager::include_install($module);
        $this->assertTrue($result);
        $this->assertCount(1, ModuleManager::$modules_install);
    }

    /**
     * @covers ModuleManager::include_install
     */
    public function testLoadingNonExistingModuleIsNotExecuted()
    {
        $module = 'Foo_Bar';
        $result = ModuleManager::include_install($module);
        $this->assertFalse($result);
        $this->assertCount(0, ModuleManager::$modules_install);
    }
}
