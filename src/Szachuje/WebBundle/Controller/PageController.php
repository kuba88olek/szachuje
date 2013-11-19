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
        return array();
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
