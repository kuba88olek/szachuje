<?php

namespace spec\Szachuje\WebBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Szachuje\WebBundle\Entity\News');
    }
}
