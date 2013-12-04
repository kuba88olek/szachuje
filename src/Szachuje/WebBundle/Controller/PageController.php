<?php

namespace Szachuje\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Szachuje\WebBundle\Form\ContactType;

class PageController extends Controller
{
    /**
     * @Route("/", name="szachuje_index")
     * @Template()
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $newsRepo = $manager->getRepository('SzachujeWebBundle:News');
        $qb = $newsRepo->createQueryBuilder('n');
        $qb->orderBy('n.date', 'DESC')
            ->setMaxResults(3);

        return array(
            'news' => $qb->getQuery()->getResult(),
        );
    }

    /**
     * @Route("/kontakt", name="szachuje_contact")
     * @Template
     */
    public function contactAction()
    {
        $contactForm = $this->createForm(new ContactType());

        $request = $this->getRequest();
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

    private function sendEmail($data)
    {
        $body = $this->renderView('SzachujeWebBundle::contact_email.txt.twig', $data);

        $translator = $this->get('translator');
        $message = \Swift_Message::newInstance()
            ->setSubject($translator->trans('contact_form.message.subject'))
            ->setFrom($data['email'])
            ->setTo('szachuje@example.com')
            ->setBody($body);

        $this->get('mailer')->send($message);
    }

}
