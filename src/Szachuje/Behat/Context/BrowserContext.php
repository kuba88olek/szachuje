<?php

namespace Szachuje\Behat\Context;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;

class BrowserContext extends RawMinkContext
{
    protected $browserWidth;
    protected $browserHeight;

    public function __construct($browserWidth, $browserHeight)
    {
        $this->browserWidth = $browserHeight;
        $this->browserHeight = $browserHeight;
    }

    public function resizeBrowserWindow()
    {
        if ($this->getSession()->getDriver() instanceof Selenium2Driver) {
            $this->getSession()->getDriver()->resizeWindow(
                $this->browserWidth,
                $this->browserHeight
            );
        }
    }
}