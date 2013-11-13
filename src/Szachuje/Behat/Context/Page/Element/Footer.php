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
        return $this->has('css', 'h3:contains("'.$footerText.'")');
    }

    public function hasDetails($footerText)
    {
        return $this->has('css', 'p:contains("'.$footerText.'")');
    }

    public function hasMenuElement($element)
    {
        return $this->has('css', 'nav ul li:contains("'.$element.'")');
    }

    public function visibilityMenuInMobile()
    {
        return $this->find('css', 'nav')->isVisible();
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
}
