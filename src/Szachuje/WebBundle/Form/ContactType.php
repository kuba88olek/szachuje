<?php

namespace Szachuje\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', 'text', array(
                'label' => 'contact_form.first_name',
                'constraints' => array(
                    new Constraints\Length(array('max' => 255)),
                ),
            ))
            ->add('last_name', 'text', array(
                'label' => 'contact_form.last_name',
                'constraints' => array(
                    new Constraints\Length(array('max' => 255)),
                ),
            ))
            ->add('email', 'email', array(
                'label' => 'contact_form.email',
                'constraints' => array(
                    new Constraints\NotBlank(),
                    new Constraints\Length(array('max' => 255)),
                    new Constraints\Email(),
                ),
            ))
            ->add('phone', 'text', array(
                'label' => 'contact_form.phone',
                'constraints' => array(
                    new Constraints\Length(array('min' => 9, 'max' => 9)),
                ),
            ))
            ->add('content', 'textarea', array(
                'label' => 'contact_form.content',
                'constraints' => array(
                    new Constraints\NotBlank(),
                ),
            ))
        ;
    }

    public function getName()
    {
        return 'contact';
    }
}
