<?php
/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\InstallerBundle\Installer;

use JMS\DiExtraBundle\Annotation as DI;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @DI\Service("installer")
 */
class Installer
{
    /**
     * @var Container $container
     */
    protected $container;

    /**
     * Default available steps
     *
     * @param array $steps
     */
    protected $steps = array('license_agreement', 'system_check', 'database_config', 'system_information');

    /**
     * Object instance of current step
     *
     * @param Step $step
     */
    protected $step;

    /**
     * Constructer to initialize the installer
     *
     * @param Container $container
     *
     * @DI\InjectParams({
     *     "container" = @DI\Inject("service_container")
     * })
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);

        $session = $this->getSession('step');

        // If we don't have a step in the session yet (I.E first time we open installer), default to first step
        if (!$session) {
            $key = 0;
        } else {
            // otherwise search for current step
            $key = array_search($session, $this->steps);
        }

        $this->step($this->steps[$key]);
    }

    /**
     * Validte the current installation step to ensure paramaters are met
     *
     * @return RedirectResponse|false RedirectResponse|boolean
     */
    public function validateStep($options)
    {
        $this->step->clear();

        // if step is valid, continue to next step
        if ($this->step->validate($options)) {
            // Process the current step (save configuration data, run database queries etc)
            $this->step->process($options);

            $step = $this->getSession('step');

            $key = array_search($step, $this->steps);

            $key++;

            if (!isset($this->steps[$key])) {
                $route = $this->getContainer()->get('router')->generate('_installer_success');

                return new RedirectResponse($route);
            }

            $this->step($this->steps[$key]);

            // save all the request data in the session so we can use it later
            $this->setSession($step, $options);

            $route = $this->getContainer()->get('router')->generate('_installer');

            return new RedirectResponse($route);
        }

        return false;
    }

    /**
     * Get the current installation step
     *
     * @return string
     */
    public function getStep()
    {
        // get necessary information for current step
        $this->step->start();

        return $this->step;
    }

    /**
     * Get the session data for specific step
     *
     * @return mixed
     * @param  string $key
     */
    public function getSession($key)
    {
        return unserialize($this->getContainer()->get('session')->get('installer.'.$key));
    }

    /**
     * Sets session data for specific key in installation process
     *
     * @return Installer
     */
    public function setSession($key, $value)
    {
        $session = $this->getContainer()->get('session');
        $session->set('installer.'.$key, serialize($value));

        return $this;
    }

    /**
     * Gets the service container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Sets the instance of the container
     *
     * @param  Container $container
     * @return Installer
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Returns an array of all available steps, formatted to human-readible name
     *
     * @return array
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Return the current active step
     *
     * @return string
     */
    public function active()
    {
        return $this->getSession('step');
    }

    /**
     * Creates an instance of the necessary step class
     *
     * @param  string $step
     * @return string
     */
    protected function step($step_name = null)
    {
        $step = $this->_checkName($step_name);

        $this->setSession('step', $step_name);

        $class = __NAMESPACE__.'\\Step\\'.$step;

        $this->step = new $class;

        $this->step->setContainer($this->getContainer());

        return $this->step;
    }

    /**
     * Converts a name to camelcase
     *
     * @param  string $name
     * @return mixed
     */
    private function _checkName($name = '')
    {
        // TODO : we should use a regular expression, instead of doing double str_replace
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
    }
}
