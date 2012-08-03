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
use Symfony\Component\HttpKernel\HttpKernel;

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
     * Core paths for assets
     * 
     * @var array $core_paths
     */
    protected $core_paths = array('css', 'images', 'js');

    /**
     * Core routes
     * 
     * @var array $core_routes
     */
    protected $core_routes = array('_installer', '_profiler', '_wdt');

    /**
     * @DI\Observe("kernel.request", priority = 10)
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
		$route = $event->getRequest()->get('_route');
		
		$map = array_map(function($route) use ($event){
			
				return strpos($event->getRequest()->getPathInfo(), $route);
			}, $this->core_paths);
		
		if(!in_array($route, $this->core_routes) && !in_array(true, $map) && $event->getRequestType() === HttpKernel::MASTER_REQUEST)
		{
			// first we check if we can connect to the database
			try {
				$this->container->get('database_connection')->connect();
			} catch (\Exception $e) {
				// TODO: if we can't connect to the database, check if the application is installed or not.
				// If not, go to the installer. If application is already installed, then just display an error message
				$response = new RedirectResponse($this->container->get('router')->generate('_installer'));
			
				return $event->setResponse($response);
			}
		
			// TODO: check (settings table|composer.lock file) for current installed version. If version can't be found, run installer
			// if version is older than available version, go to upgrade page (unless automatic update is activiated)
			// (Should we automatically take user to upgrade page, or just notifu that a new version is available?)
			
			/**
			 * Temporary Implemation
			 */

			// check if the users table exists. If not, go to installer
			$repository = $this->container->get('doctrine.orm.entity_manager')->getRepository('CSUserBundle:User');
			
			try {
				$repository->find('u')->execute();
			} catch(\PDOException $e)
			{
				$response = new RedirectResponse($this->container->get('router')->generate('_installer'));

				return $event->setResponse($response);
			}
			
			// check if there are any users loaded. If not, run the installer
			$users = $repository->findAll();
			
			// TODO: get different way of checking if the application is installed or not
			if(count($users) === 0)
			{
				$response = new RedirectResponse($this->container->get('router')->generate('_installer'));
			} else {
				$response = new RedirectResponse($this->container->get('router')->generate('_dashboard'));
			}

			return $event->setResponse($response);
		}
    }
}
