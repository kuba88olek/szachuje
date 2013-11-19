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
        $repo = $this->getDoctrine()
            ->getRepository('SzachujeWebBundle:News');
        $query = $repo
            ->createQueryBuilder('news')
            ->orderBy('news.dateAdd', 'desc')
            ->setMaxResults(3)
            ->getQuery();
        $news = $query->getResult();
        return array('news' => $news);
    }

    /**
     * @Route("/o-nas", name="szachuje_about_us")
     * @Template()
     */
    public function aboutUsAction()
    {
        return array();
    }

    /**
     * @Route("/kontakt", name="szachuje_contact")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }
}
