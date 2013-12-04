<?php

namespace Szachuje\WebBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;
use Szachuje\WebBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\FormFactory;

class PageController extends Controller
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

    public function __construct(EntityManager $em, FormFactory $formFactory,
                    EngineInterface $templating, Translator $translator, \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->translator = $translator;
        $this->mailer = $mailer;
    }

    /**
     * @Template()
     */
    public function indexAction()
    {
        $newsRepo = $this->em->getRepository('SzachujeWebBundle:News');
        $qb = $newsRepo->createQueryBuilder('n');
        $qb->orderBy('n.date', 'DESC')
            ->setMaxResults(3);

        return array(
            'news' => $qb->getQuery()->getResult(),
        );
    }

    /**
     * @Template
     */
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

        return array(
            'form' => $contactForm->createView(),
            'message' => empty($message) ? null: $message,
        );
    }

    public function sendEmail($data)
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
