<?php
class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  public static $browsers = array(
    array(
      'name'    => 'Firefox on MacOS X',
      'browser' => '*firefox',
    ),
    array(
      'name'    => 'Google Chrome on MacOS X',
      'browser' => '*googlechrome',
    ),
    array(
        'name'    => 'Safari on MacOS X',
        'browser' => '*safari',
    ),
  );

  protected function setUp()
  {
    $this->setBrowserUrl("http://theialive.azurewebsites.net/");
  }

  public function testSuccessfulLogin()
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

  public function testLoginWithBogusCredentials()
  {
    $email = "foo";
    $password = "bar";
    $this->open("/");
    $this->click("link=login");
    $this->waitForPageToLoad("30000");
    $this->type("id=email", $email);
    $this->type("id=password", $password);
    $this->click("id=signin");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("'" . $email . "' is not a valid email address in the basic format local-part@hostname", $this->getText("xpath=//ul[@class=\"errors\"]/li[1]"));
    $this->assertEquals("'" . $email . "' is less than 5 characters long", $this->getText("xpath=//ul[@class=\"errors\"]/li[2]"));
  }

  public function testFailedLoginWithWrongEmail()
  {
    $email = "foo@bar.com";
    $password = "bar";
    $this->open("/");
    $this->click("link=login");
    $this->waitForPageToLoad("30000");
    $this->type("id=email", $email);
    $this->type("id=password", $password);
    $this->click("id=signin");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("Invalid username and/or password provided", $this->getText("xpath=//ul[@class=\"errors\"]/li[1]"));
  }

  public function testFailedLoginWithWrongPassword()
  {
    $email = "promo@in2it.be";
    $password = "bar";
    $this->open("/");
    $this->click("link=login");
    $this->waitForPageToLoad("30000");
    $this->type("id=email", $email);
    $this->type("id=password", $password);
    $this->click("id=signin");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("Invalid username and/or password provided", $this->getText("xpath=//ul[@class=\"errors\"]/li[1]"));
  }
}
?>