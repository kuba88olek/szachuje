<?php

namespace spec\Szachuje\WebBundle\Controller;

use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
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
    public function let(EntityManager $em, FormFactory $formFactory,
        TwigEngine $templating, Translator $translator, \Swift_Mailer $mailer)
    {
        $this->beConstructedWith($em, $formFactory, $templating, $translator, $mailer);
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

}
