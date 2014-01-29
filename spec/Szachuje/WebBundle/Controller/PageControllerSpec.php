<?php

namespace spec\Szachuje\WebBundle\Controller;

use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\Response;
use Szachuje\WebBundle\Entity\News;
use Prophecy\Argument;

class PageControllerSpec extends ObjectBehavior
{
    public function let(EntityManager $em, FormFactory $formFactory, TwigEngine $templating, Translator $translator,
        \Swift_Mailer $mailer, Router $router)
    {
        $this->beConstructedWith($em, $formFactory, $templating, $translator, $mailer, $router);
    }

    public function it_should_render_homepage(EntityManager $em, TwigEngine $templating, EntityRepository $repository,
          News $news)
    {
        $em->getRepository('SzachujeWebBundle:News')
            ->shouldBeCalled()
            ->willReturn($repository);

        $repository->findBy(array(), array('date' => 'DESC'), 3)
            ->shouldBeCalled()
            ->willReturn(array($news, $news, $news));

        $templating->renderResponse('SzachujeWebBundle:Page:index.html.twig', array(
            'news' => array($news, $news, $news),
        ))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $this->indexAction()->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }

    public function it_should_render_contactpage(FormFactory $formFactory, Form $form, Request $request,
        TwigEngine $templating, FormView $formView)
    {
        $formFactory->create(Argument::type('Szachuje\WebBundle\Form\ContactType'))
            ->shouldBeCalled()
            ->willReturn($form);

        $form->createView()->shouldBeCalled()->willReturn($formView);
        $request->isMethod('POST')->willReturn(false);

        $templating->renderResponse('SzachujeWebBundle:Page:contact.html.twig', array(
            'form' => $formView,
            'message' => null,
        ))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $this->contactAction($request)->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }

    public function it_should_not_send_email_on_invalid_data(FormFactory $formFactory, Form $form, Request $request,
        \Swift_Mailer $mailer, Router $router, TwigEngine $templating, FormView $formView)
    {
        $formFactory->create(Argument::type('Szachuje\WebBundle\Form\ContactType'))->willReturn($form);
        $request->isMethod('POST')->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled();
        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->createView()->shouldBeCalled()->willReturn($formView);

        $mailer->send(Argument::type('\Swift_Message'))
            ->shouldNotBeCalled();

        $templating->renderResponse('SzachujeWebBundle:Page:contact.html.twig', array(
            'form' => $formView,
            'message' => 'contact_form.invalid',
        ))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $this->contactAction($request)->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }

    public function it_should_send_email(FormFactory $formFactory, Form $form, Request $request,
         \Swift_Mailer $mailer, Router $router, TwigEngine $templating, FormView $formView)
    {
        $formFactory->create(Argument::type('Szachuje\WebBundle\Form\ContactType'))->willReturn($form);
        $request->isMethod('POST')->willReturn(true);
        $form->handleRequest($request)->shouldBeCalled();
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $form->createView()->shouldBeCalled()->willReturn($formView);

        $formData = array(
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'email' => 'jan@example.com',
            'phone' => '123456789',
            'content' => 'Lorem Ipsum',
        );
        $form->getData()->willReturn($formData);

        $templating->render('SzachujeWebBundle::contact_email.txt.twig', $formData)
            ->shouldBeCalled();

        $mailer->send(Argument::type('\Swift_Message'))
            ->shouldBeCalled();

        $templating->renderResponse('SzachujeWebBundle:Page:contact.html.twig', array(
            'form' => $formView,
            'message' => 'contact_form.send',
        ))
            ->shouldBeCalled()
            ->willReturn(new Response());

        $this->contactAction($request)->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }

}