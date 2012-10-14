<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\CoreBundle\Annotation;

/**
 * @Annotation
 */
final class Menu {

	/** @var string */
	public $menu;

	/** @var string */
	public $block;
}