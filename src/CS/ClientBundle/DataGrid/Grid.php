<?php

/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\ClientBundle\DataGrid;

use CS\DataGridBundle\Grid\BaseGrid;
use CS\DataGridBundle\Grid\Column\ColumnCollection;

class Grid extends BaseGrid {

    /**
     * returns the entity name for the cliets
     *
     * @see CS\DataGridBundle\Grid.BaseGrid::getSource()
     * @return string
     */
    public function getSource()
    {
        return 'CSClientBundle:Client';
    }

    /**
     * @return string The name of the current grid
     */
    public function getName()
    {
        return 'clients';
    }

    /**
     * Manupulate the columns for the clients grid
     *
     * @param ColumnCollection $collection
     * @return void
     */
    public function getColumns(ColumnCollection $collection)
    {
        $collection->remove(array('deleted', 'updated'));

        $collection['id']->setLabel('#');
    }
}