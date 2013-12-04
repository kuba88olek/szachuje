<?php

namespace spec\Szachuje\WebBundle\Controller;

use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Szachuje\WebBundle\Form\ContactType;
use Prophecy\Argument;

class PageControllerSpec extends ObjectBehavior
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    public function let(EntityManager $em, FormFactory $formFactory,
                        EngineInterface $templating, Translator $translator, \Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->beConstructedWith($em, $formFactory, $templating, $translator, $mailer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Szachuje\WebBundle\Controller\PageController');
    }

    public function it_should_call_email()
    {
        $this->mailer->send(Argument::type('Swift_Message'))->shouldBeCalled();

        $this->sendEmail(array(
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'email' => 'jan@example.com',
            'phone' => '123456789',
            'content' => 'Lorem Ipsum',
            'submit' => 'Wyślij',
        ));
    }

}
