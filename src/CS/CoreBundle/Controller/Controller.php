<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as CoreController;

use JMS\DiExtraBundle\Annotation as DI;

class Controller extends CoreController {

	/**
	 * Gets the entity manager for the current controller
	 *
	 * @return \Doctrine\ORM\Entityanager
	 */
    public function getEm()
    {
    	return $this->get('doctrine.orm.entity_manager');
    }
}
