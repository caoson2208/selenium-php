<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once __DIR__ . '/../BrowserConfig.php';

class LoginTest extends TestCase
{
    protected $webDriver;
    private $urlLogin = 'https://dms.hurav.com/admin/login';
    private $browser = 'chrome';
    private $cookieFile = __DIR__ . '/cookies.json';


    public function setUp(): void
    {
        $host = 'http://localhost:4444/wd/hub';
        $capabilities = BrowserConfig::getCapabilities($this->browser);
        $this->webDriver = RemoteWebDriver::create($host, $capabilities);
        $this->webDriver->get($this->urlLogin);
    }

    // public function testLoginSuccess(): void
    // {
    //     $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
    //     $emailField->sendKeys('admin@dms.com');

    //     $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
    //     $passwordField->sendKeys('7349yiey@939FF');

    //     $loginButton = $this->webDriver->findElement(
    //         WebDriverBy::xpath("//button[@type='submit' and contains(text(), 'Login')]")
    //     );
    //     $loginButton->click();

    //     $expectedUrl = 'https://dms.hurav.com/admin';
    //     $currentUrl = $this->webDriver->getCurrentURL();
    //     $this->assertEquals($expectedUrl, $currentUrl, 'URL sau khi đăng nhập không đúng!');

    //     // Save cookies
    //     $cookies = $this->webDriver->manage()->getCookies();
    //     file_put_contents($this->cookieFile, json_encode($cookies));
    // }

     public function testLoginWithEmailInvalid(): void
    {
        $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
        $emailField->sendKeys('admin@');

        $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
        $passwordField->sendKeys('7349yiey@939FF');

        $errorMessage = $this->webDriver->findElement(WebDriverBy::xpath('//*[@id="app"]/div/div/div/div/form/div[2]/div[1]/div[2]')); 
        $expectedErrorMeassage = 'The email field must be a valid email';
        $this->assertEquals($errorMessage->getText(), $expectedErrorMeassage, 'Notification message is not correct');
    }

    public function testLoginWithPasswordlInvalid(): void
    {
        $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
        $emailField->sendKeys('admin@dms.com');

        $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
        $passwordField->sendKeys('7349yiey');

        $loginButton = $this->webDriver->findElement(
            WebDriverBy::xpath("//button[@type='submit' and contains(text(), 'Login')]")
        );
        $loginButton->click();

        $expectedErrorMeassage = $this->webDriver->findElement(WebDriverBy::cssSelector('form > div.auth-body > div.alert.alert-danger > ul > li'));
        $currentUrl = $this->webDriver->getCurrentURL();
        $this->assertEquals($expectedErrorMeassage->getText(), $currentUrl, 'Notification message is not correct');

        // Save cookies
        $cookies = $this->webDriver->manage()->getCookies();
        file_put_contents($this->cookieFile, json_encode($cookies));
    }

    public function tearDown(): void
    {
        if ($this->webDriver) {
            $this->webDriver->quit();
        }
    }
}
