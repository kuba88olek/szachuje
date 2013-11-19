<?php

namespace Szachuje\WebBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function headerMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('header_menu');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('header.menu.main_page', array('route' => 'szachuje_index'));
        $menu->addChild('header.menu.about_us', array('route' => 'szachuje_about_us'));
        $menu->addChild('header.menu.contact', array('route' => 'szachuje_contact'));

        return $menu;
    }

    public function footerMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('footer_menu');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('footer.menu.main_page', array('route' => 'szachuje_index'));
        $menu->addChild('footer.menu.about_us', array('route' => 'szachuje_about_us'));
        $menu->addChild('footer.menu.contact', array('route' => 'szachuje_contact'));

        return $menu;
    }
}
