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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Finder\Finder;

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
		// TODO : add this logic to service, so we only need to call the service to get the correct step
		$root_dir = dirname($this->get('kernel')->getRootDir());
		
		$finder = new Finder();
		$finder->files()->in($root_dir)->depth('== 0')->filter(function(\SplFileInfo $file){
				if($file->getExtension() !== '')
				{
					return false;
				}
			});
		
		$license = '';
		
		foreach($finder as $file)
		{
			if(strtolower($file->getBasename()) === 'license')
			{
				$license = $file->getContents();
				break;
			}
		}

        return array('license' => $license);
    }
}
