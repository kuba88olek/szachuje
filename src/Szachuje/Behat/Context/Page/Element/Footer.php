<?php

namespace Szachuje\Behat\Context\Page\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use Symfony\Component\Config\Definition\Exception\Exception;

class Footer extends Element
{
    /**
     * @var array $selector
     */
    protected $selector = array('css' => 'footer');

    public function hasContactTitleElement($footerText)
    {
        return $this->has('css', sprintf('h1:contains("%s")', $footerText));
    }

    public function hasDetails($footerText)
    {
        return $this->has('css', sprintf('p:contains("%s")', $footerText));
    }

    public function hasMenuElement($element)
    {
        return $this->has('css',  sprintf('nav ul li:contains("%s")', $element));
    }

    public function isMenuVisible($browserType)
    {
        switch ($browserType) {
            case 'pc':
                return $this->find('css', 'nav')->isVisible();
                break;
            case 'mobile':
                return $this->find('css', 'nav')->isVisible();
                break;
            default:
                throw new Exception("Browser type not valid");
        }
    }

    public function isMenuElementActive($menuElement)
    {
        return $this->find('css',  sprintf('nav ul li:contains("%s")', $menuElement))->hasClass('current');
    }
}
