<?php

namespace Szachuje\Behat\Context\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class StronaGlowna extends Page
{
    protected $path = '/';

    public function getContentFirst()
    {
        $element = $this->find('css', '#content-first');

        if (empty($element)) {
            throw new \Exception('element "#content-first" not found');
        }

        return $element->getHtml();
    }

    public function getContentSecond()
    {
        $element = $this->find('css', '#content-second');

        if (empty($element)) {
            throw new \Exception('element "#content-second" not found');
        }

        return $element->getHtml();
    }

}
