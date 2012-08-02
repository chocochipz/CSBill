<?php

namespace CS\InstallerBundle\Installer\Step;

use Symfony\Component\Process\Process;

use CS\InstallerBundle\Installer\Step;

class SystemCheck extends Step
{
    /**
     * The view to render for this installation step
     *
     * @param string $view;
     */
    public $view = 'CSInstallerBundle:Install:system_check.html.twig';

    /**
     * The title to display when this installationj step is active
     *
     * @param string $title
     */
    public $title = 'System Check';
    
    /**
     * Contains an array of all the required and optional checks to see if it passed
     * 
     * @var array $check
     */
    public $check;

    /**
     * Validates that the system meets the minimum requirements
     *
     * @param  array   $request
     * @return boolean
     */
    public function validate($request = array())
    {
		$this->start();
		
		foreach($this->check['recommended']['values'] as $value)
		{
			if(substr(trim($value), 0, 2) !== 'OK')
			{
				return false;
			}
		}

        return true;
    }

    /**
     * Not implemented
     */
    public function process($request = array()){}

    /**
     * Checks the system to make sure it meets the minimum requirements
     *
     * @return void
     */
    public function start()
    {
		$process = new Process('php ../app/check.php');
		$process->setTimeout(3600);
		$process->run();
		if (!$process->isSuccessful()) {
			throw new RuntimeException($process->getErrorOutput());
		}

		$check = $process->getOutput();
		
		$output = explode("\n", $check);
		
		$recommended = $this->getOutput($output, 'mandatory requirements');
		$optional = $this->getOutput($output, 'optional recommendations');
		
		$this->check = array('recommended' => $recommended, 'optional' => $optional);
    }
    
    public function getOutput($output = array(), $header = '')
    {
		while(($line = next($output)) !== false)
		{
			if(strpos(strtolower($line), strtolower($header)) !== false)
			{
				$content = array();
				$heading = trim(str_replace('**', '', $line));
				
				do {
					$line = next($output);
				} while (substr($line, 0, 1) === '*');
				
				$line = next($output);
				
				$line = next($output);

				do {
					$content[] = $line;
					$line = next($output);
				} while(substr(strtolower($line), 0, 2) !== '**' && $line);
			}
		}
		
		return array('heading' => $heading, 'values' => $content);
	}
}
