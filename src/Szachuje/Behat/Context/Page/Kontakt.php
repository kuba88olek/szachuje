<?php

namespace Szachuje\Behat\Context\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class Kontakt extends Page
{
    protected $path = '/kontakt';

    public function getMessage()
    {
        return $this->find('css', '.alert');
    }
}
