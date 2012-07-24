<?php

namespace CS\InstallerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return array('name' => 'installer');
    }
}
