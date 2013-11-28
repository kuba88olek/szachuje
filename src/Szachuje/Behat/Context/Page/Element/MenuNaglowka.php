<?php

namespace Szachuje\Behat\Context\Page\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class MenuNaglowka extends Element
{
    protected $selector = array('css' => '#menu-top');

    public function getElementsCount()
    {
        $articles = $this->findAll('css', 'li');
        return count($articles);
    }

    public function getElementText($index)
    {
        $element = $this->find('xpath', sprintf('/li[position()=%d]//a', $index));

        if (empty($element)) {
            throw new \Exception('element "li:nth-child(%d) a" not found');
        }

        return $element->getText();
    }

}
