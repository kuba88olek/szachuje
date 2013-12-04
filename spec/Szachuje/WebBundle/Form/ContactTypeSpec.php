<?php

namespace spec\Szachuje\WebBundle\Form;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints;

class ContactTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Szachuje\WebBundle\Form\ContactType');
    }

    public function it_have_name()
    {
        $this->getName()->shouldReturn('contact');
    }

    public function it_add_fields_during_build_form(FormBuilder $builder)
    {
        $builder->setMethod('POST')->shouldBeCalled();

        $builder->add('first_name', 'text', array(
            'label' => 'contact_form.first_name',
            'constraints' => array(
                new Constraints\Length(array('max' => 255)),
            ),
        ))->shouldBeCalled();

        $builder->add('last_name', 'text', array(
            'label' => 'contact_form.last_name',
            'constraints' => array(
                new Constraints\Length(array('max' => 255)),
            ),
        ))->shouldBeCalled();

        $builder->add('email', 'email', array(
            'label' => 'contact_form.email',
            'constraints' => array(
                new Constraints\NotBlank(),
                new Constraints\Length(array('max' => 255)),
                new Constraints\Email(),
            ),
        ))->shouldBeCalled();

        $builder->add('phone', 'text', array(
            'label' => 'contact_form.phone',
            'constraints' => array(
                new Constraints\Length(array('min' => 9, 'max' => 9)),
            ),
        ))->shouldBeCalled();

        $builder->add('content', 'textarea', array(
            'label' => 'contact_form.content',
            'constraints' => array(
                new Constraints\NotBlank(),
            ),
        ))->shouldBeCalled();

        $builder->add('submit', 'submit', array(
            'label' => 'contact_form.submit',
        ))->shouldBeCalled();

        $this->buildForm($builder, array());
    }

}
