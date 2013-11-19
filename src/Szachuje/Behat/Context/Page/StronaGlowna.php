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
}
