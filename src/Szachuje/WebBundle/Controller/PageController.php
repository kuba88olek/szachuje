<?php

namespace Szachuje\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
