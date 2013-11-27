<?php

namespace Szachuje\Behat\Context;

use Behat\Behat\Context\BehatContext;

class FeatureContext extends BehatContext
{
    function __construct($parameters = array())
    {
        $this->useContext('browser', new BrowserContext($parameters['browser_width'], $parameters['browser_height']));
        $this->useContext('web-user', new WebUserContext());
    }

}