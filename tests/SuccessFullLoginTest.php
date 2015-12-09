<?php
class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://theialive.azurewebsites.net/");
  }

  public function testMyTestCase()
  {
    $email = "promo@in2it.be";
    $password = "test1234";
    $this->open("/");
    $this->click("link=login");
    $this->waitForPageToLoad("30000");
    $this->type("id=email", $email);
    $this->type("id=password", $password);
    $this->click("id=signin");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("TheiaLive | Your current projects", $this->getTitle());
    $this->click("link=sign off");
    $this->waitForPageToLoad("30000");
  }
}
?>