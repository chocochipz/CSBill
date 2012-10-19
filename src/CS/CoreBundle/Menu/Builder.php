<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\CoreBundle\Menu;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * The core menu builder, used to build the sidebar and top menus
 *
 * @DI\Service("cs_core.menu.builder")
 * @DI\Tag("cs_menu.builder")
 */
class Builder
{
    /**
     * @DI\Inject("knp_menu.factory");
     */
    public $factory;

    /**
     * Menu builder for the sidebar menus
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function sidebarMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Dashboard', array('route' => '_dashboard'));

        $menu->setChildrenAttributes(array('class' => 'nav nav-list'));

        return $menu;
    }

    /**
     * Menu builder for the top menu
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function topMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('Home', array('route' => '_dashboard'));
        $menu->addChild('Clients', array('route' => '_client_index'));

        return $menu;
    }
}
