<?php

namespace Szachuje\Behat\Context\Page\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use Symfony\Component\Config\Definition\Exception\Exception;


class Header extends Element
{
    /**
     * @var array $selector
     */
    protected $selector = array('css' => 'header');

    public function hasLogo($browserType)
    {
        switch ($browserType) {
            case 'pc':
                return $this->has('css', '#logo');
                break;
            case 'mobile':
                return $this->find('css', '#logo')->isVisible();
                break;
            default:
                throw new Exception("Browser type not valid");
        }
    }

    public function hasMenuElement($element)
    {
        return $this->has('css',  sprintf('nav ul li:contains("%s")', $element));
    }

    public function isMenuElementActive($menuElement)
    {
        return $this->find('css',  sprintf('nav ul li:contains("%s")', $menuElement))->hasClass('current');
    }
}
