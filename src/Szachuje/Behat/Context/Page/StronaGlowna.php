<?php

namespace Szachuje\Behat\Context\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class StronaGlowna extends Page
{
    protected $path = '/';

    public function isHeaderMenuElementActive($menuElement)
    {
        return $this->getElement('Header')->isMenuElementActive($menuElement);
    }

    public function isFooterMenuElementActive($menuElement)
    {
        return $this->getElement('Footer')->isMenuElementActive($menuElement);
    }

    public function hasHeaderText($headerText)
    {
        return $this->has('css', sprintf('h1:contains("%s")', $headerText));
    }

    public function hasWelcomeContent()
    {
        return $this->has('css', 'section p#welcome-text');
    }

    public function isImageVisible($browserType)
    {
        switch ($browserType) {
            case 'pc':
                return $this->has('css', 'section img#firm-img');
                break;
            case 'mobile':
                return $this->find('css', 'section img#firm-img')->isVisible();
                break;
            default:
                throw new Exception("Browser type not valid");

        }
    }

    public function getWelcomeText()
    {
        $welcomeContent = $this->find('css', 'section p#welcome-text');
        return $welcomeContent->getText();
    }

    public function getSecondText()
    {
        $secondContent = $this->find('css', 'section p#second-text');
        return $secondContent->getText();
    }
}
