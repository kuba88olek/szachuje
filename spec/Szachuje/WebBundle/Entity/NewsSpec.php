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

    function it_converts_to_string_and_returns_title()
    {
        $this->setTitle('test');
        $this->__toString()->shouldReturn($this->getTitle());
    }
}
