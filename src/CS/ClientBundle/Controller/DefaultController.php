<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CS\CoreBundle\Controller\Controller;
use CS\ClientBundle\DataGrid\Grid;

/**
 * @Route("/clients")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="_client_index")
     * @Template()
     */
    public function indexAction()
    {
        $grid = $this->get('grid')->create(new Grid);

        return array('grid' => $grid);
    }

    /**
     * @Route("/add", name="_client_add")
     * @Template()
     */
    public function addAction()
    {
        return array();
    }

    /**
     * @Route("/edit", name="_client_edit")
     * @Template()
     */
    public function editAction()
    {
        return array();
    }
}
