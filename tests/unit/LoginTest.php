<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once __DIR__ . './../BrowserConfig.php';

class LoginTest extends TestCase
{
    protected $webDriver;
    private $browser = 'chrome';

    public function setUp(): void
    {
        $host = 'http://localhost:4444/wd/hub';
        $capabilities = BrowserConfig::getCapabilities($this->browser);
        $this->webDriver = RemoteWebDriver::create($host, $capabilities);
    }

   public function testLogin(): void
    {
        $this->webDriver->get('https://dms.hurav.com/admin/login');

        $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
        $emailField->sendKeys('admin@dms.com');

        $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
        $passwordField->sendKeys('7349yiey@939FF');

        $loginButton = $this->webDriver->findElement(
            WebDriverBy::xpath("//button[@type='submit' and contains(text(), 'Login')]")
        );
        $loginButton->click();

        $expectedUrl = 'https://dms.hurav.com/admin';
        $currentUrl = $this->webDriver->getCurrentURL();
        $this->assertEquals($expectedUrl, $currentUrl, 'URL sau khi đăng nhập không đúng!');
    }

    public function testLoginFail(): void
    {
        $this->webDriver->get('https://dms.hurav.com/admin/login');

        $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
        $emailField->sendKeys('admin@dms.com123');

        $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
        $passwordField->sendKeys('7349yiey@939FF');

        $loginButton = $this->webDriver->findElement(
            WebDriverBy::xpath("//button[@type='submit' and contains(text(), 'Login')]")
        );
        $loginButton->click();

        $expectedUrl = 'https://dms.hurav.com/admin/login';
        $currentUrl = $this->webDriver->getCurrentURL();
        $this->assertEquals($expectedUrl, $currentUrl, 'URL sau khi đăng nhập sai không đúng!');
    }


    public function tearDown(): void
    {
        $this->webDriver->quit();
    }
}
