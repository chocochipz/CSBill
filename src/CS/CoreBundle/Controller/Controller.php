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

class Controller extends CoreController
{
    /**
     * Gets the entity manager for the current controller
     *
     * @return \Doctrine\ORM\Entityanager
     */
    public function getEm()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * Returns the current session object
     *
     * @return object
     */
    public function getSession()
    {
        return $this->get('session');
    }

    /**
     * Redirects the user to a path with a flash message
     *
     * @param  string                                             $route
     * @param  string                                             $message
     * @param  string                                             $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectFlash($route, $message = '', $status = 'notice')
    {
        $url = $this->generateUrl($route);

        $this->setFlash($status, $message);

        return $this->redirect($url);

    }

    /**
     * Sets a flash message
     *
     * @param  string     $status
     * @param  string     $message
     * @return Controller
     */
    public function setFlash($status = 'notice', $message = '')
    {
        $this->getSession()->getFlashBag()->add($status, $this->trans($message));

        return $this;
    }

    /**
     * Translates a string
     *
     * @param  string $message
     * @return string
     */
    public function trans($message)
    {
        return $this->get('translator')->trans($message);
    }
}
