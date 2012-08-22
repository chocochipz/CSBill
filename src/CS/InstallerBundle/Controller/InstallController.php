<?php
/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\InstallerBundle\Controller;

use CS\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/installer")
 */
class InstallController extends Controller
{
    /**
     * @Route("/", name="_installer")
     * @Template()
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->getMethod() === 'POST') {
            $response = $this->get('installer')->validateStep($request->request->all());

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        $installer = $this->get('installer');
        $step = $installer->getStep();

        return array('step' => $step, 'installer' => $installer);
    }

    /**
     * @Route("/success", name="_installer_success")
     * @Template()
     */
    public function successAction()
    {
		return array();
	}
}
