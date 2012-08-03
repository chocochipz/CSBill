<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\InstallerBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("request.check")
 */
class RequestListener
{
    /**
     * @DI\Inject("service_container")
     */
    public $container;

    /**
     * @DI\Observe("kernel.request", priority = 10)
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $script = $request->getScriptName();

        $uri = $request->getRequestUri();

        $route = str_replace($script, '', $uri);

        if ($route === '') {
            try {
                $this->container->get('database_connection')->connect();
            } catch (\Exception $e) {
                $response = new RedirectResponse($this->container->get('router')->generate('_installer'));

                return $event->setResponse($response);
            }

            $response = new RedirectResponse($this->container->get('router')->generate('_dashboard'));

            return $event->setResponse($response);
        }
    }
}
