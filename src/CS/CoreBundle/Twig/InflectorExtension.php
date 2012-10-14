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
 * @DI\Service("twig.inflector")
 * @DI\Tag("twig.extension")
 */
class InflectorExtension extends \Twig_Extension
{
    /**
     * @DI\Inject("inflector")
     */
    public $inflector;

    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFilters()
     */
    public function getFilters()
    {
        return array('singular' => new \Twig_Filter_Method($this, 'singular', array('is_safe' => array('html'))));
    }

    /**
     * Converts a string to singular
     * @param string $text
     */
    public function singular($text)
    {
        return $this->inflector->singularize($text);
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
