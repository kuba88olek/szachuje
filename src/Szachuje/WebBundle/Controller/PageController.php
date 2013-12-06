<?php

namespace Szachuje\WebBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Szachuje\WebBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\FormFactory;
use Symfony\Bundle\TwigBundle\TwigEngine;

class PageController
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var EngineInterface
     */
    protected $templating;


    public function __construct(EntityManager $em, FormFactory $formFactory, TwigEngine $templating,
        Translator $translator, \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->translator = $translator;
        $this->mailer = $mailer;
    }

    public function indexAction()
    {
        $newsRepo = $this->em->getRepository('SzachujeWebBundle:News');
        $news = $newsRepo->findBy(array(), array('date' => 'DESC'), 3);

        return $this->templating->renderResponse('SzachujeWebBundle:Page:index.html.twig', array(
            'news' => $news,
        ));
    }

    public function contactAction(Request $request)
    {
        $contactForm = $this->formFactory->create(new ContactType());

        if ($request->isMethod('POST')) {
            $contactForm->handleRequest($request);
            if ($contactForm->isValid()) {
                $this->sendEmail($contactForm->getData());
                $message = 'contact_form.send';
            } else {
                $message = 'contact_form.invalid';
            }
        }

        return $this->templating->renderResponse('SzachujeWebBundle:Page:contact.html.twig', array(
            'form' => $contactForm->createView(),
            'message' => empty($message) ? null: $message,
        ));
    }

    protected function sendEmail($data)
    {
        $body = $this->templating->render('SzachujeWebBundle::contact_email.txt.twig', $data);

        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('contact_form.message.subject'))
            ->setFrom($data['email'])
            ->setTo('szachuje@example.com')
            ->setBody($body);

        $this->mailer->send($message);
    }

}
