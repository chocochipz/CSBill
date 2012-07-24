<?php

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
	 * @DI\Inject("router")
	 */
	public $router;

	/**
	 * @DI\Inject("database_connection")
	 */
	public $db;
	
	/**
     * @DI\Observe("kernel.request", priority = 255)
     */	
	public function onKernelRequest(GetResponseEvent $event)
	{
		try {
			$this->db->connect();
		} catch(\Exception $e)
		{
			$response = new RedirectResponse($this->router->generate('_installer'));
			
			$event->setResponse($response);
		}
	}
}
