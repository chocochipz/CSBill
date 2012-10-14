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

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("core.menu")
 * @DI\Tag("twig.extension")
 */
class MenuExtension extends \Twig_Extension
{
	/**
	 * @DI\Inject("cs_menu")
	 */
	public $renderer;

	/**
	 * @DI\Inject("cs_core.menu.provider")
	 */
	public $provider;

    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        return array('menu' => new \Twig_Function_Method($this, 'menu', array('is_safe' => array('html'))));
    }

    /**
     * Converts a string to singular
     * @param string $text
     */
    public function menu($type, array $options = array())
    {
    	$menu = $this->provider->get($type);

    	return $this->renderer->render($menu, $options);
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'twig.extension';
    }
}
