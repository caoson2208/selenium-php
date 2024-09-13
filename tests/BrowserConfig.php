<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Firefox\FirefoxOptions;

class BrowserConfig
{
    public static function getCapabilities(string $browser)
    {
        switch (strtolower($browser)) {
            case 'chrome':
                $options = new ChromeOptions();
                $options->addArguments([
                    '--start-maximized',
                ]);
                $capabilities = DesiredCapabilities::chrome();
                $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
                return $capabilities;

            case 'firefox':
                $options = new FirefoxOptions();
                $options->addArguments([
                    '--kiosk',
                    '--ignore-certificate-errors',
                    '--accept-insecure-certificates',
                    '--cert-revocation-check=disable',
                    '--disable-features=Security'
                ]);
                $capabilities = DesiredCapabilities::firefox();
                $capabilities->setCapability(FirefoxOptions::CAPABILITY, $options);
                return $capabilities;


            case 'edge':
                $options = new \stdClass(); 
                $options->args = [
                    '--start-maximized',
                    '--ignore-certificate-errors'
                ];
                $capabilities = DesiredCapabilities::microsoftEdge();
                $capabilities->setCapability('ms:edgeOptions', $options);
                return $capabilities;

            default:
                throw new Exception("Trình duyệt không được hỗ trợ: $browser");
        }
    }
}
