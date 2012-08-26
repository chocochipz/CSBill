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

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerAware;
use CS\CoreBundle\Event\ConfigureMenuEvent;

class Main extends ContainerAware
{
    /**
     * Render the top menu
     *
     * @param FactoryInterface $factory
     * @param array $options
     * @return MenuItem
     */
    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('Home', array('route' => '_dashboard'));
        $menu->addChild('Clients', array('route' => '_client_index'));

        $this->container->get('event_dispatcher')->dispatch(ConfigureMenuEvent::CONFIGURE, new ConfigureMenuEvent($factory, $menu));

        return $menu;
    }
}