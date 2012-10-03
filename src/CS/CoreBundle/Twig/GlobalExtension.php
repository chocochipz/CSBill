<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\CoreBundle\Twig;

use Twig_Extension;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Creates Global twig variables in use over the entire application
 *
 * @DI\Service("twig.globals.extension")
 * @DI\Tag("twig.extension")
 */
class GlobalExtension extends Twig_Extension
{
    /**
     * @DI\Inject("service_container")
     *
     * @var ContainerInterface
     */
    public $container;

     /**
      * (non-PHPdoc)
      * @see Twig_Extension::getGlobals()
      */
    public function getGlobals()
    {
        return array(
                    'sessionId' => session_id(),
                    'query'		=> $this->getQuery(),
                    'today'		=> new \DateTime,
                );
    }

    /**
     * Gets all the query parameters
     *
     * @return array
     */
    protected function getQuery()
    {
        $request = $this->container->get('request');

        $params = array_merge($request->query->all(), $request->attributes->all());

        foreach ($params as $key => $param) {
            if (substr($key, 0, 1) == '_') {
                unset($params[$key]);
            }
        }

        return $params;
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
     public function getName()
     {
         return 'global_extension';
     }
 }
