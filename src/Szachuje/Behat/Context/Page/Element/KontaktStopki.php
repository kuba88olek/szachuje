<?php

namespace Szachuje\Behat\Context\Page\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class KontaktStopki extends Element
{
    protected $selector = array('css' => '#footer-contact');

    public function getElementsCount()
    {
        $articles = $this->findAll('css', '.element');
        return count($articles);
    }

    public function getElementText($index)
    {
        $element = $this->find('css', sprintf('.element:nth-child(%d)', $index));

        if (empty($element)) {
            throw new \Exception('element ".element:nth-child(%d)" not found');
        }

        return $element->getText();
    }

}
