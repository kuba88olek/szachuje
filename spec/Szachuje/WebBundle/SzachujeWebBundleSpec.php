<?php

namespace spec\FSi\TrainingBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SzachujeWebBundleSpec extends ObjectBehavior
{
    function it_is_a_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }
}
