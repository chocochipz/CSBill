<?php
/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CS\InstallerBundle\Installer\Step;

use Symfony\Component\Process\Process;

use CS\InstallerBundle\Installer\Step;

class SystemCheck extends Step
{
    /**
     * The view to render for this installation step
     *
     * @var string $view;
     */
    public $view = 'CSInstallerBundle:Install:system_check.html.twig';

    /**
     * The title to display when this installation step is active
     *
     * @var string $title
     */
    public $title = 'System Check';

    /**
     * Contains an array of all the required and optional checks to see if it passed
     *
     * @var array $check
     */
    public $check;

    /**
     * The root directory of the application
     *
     * @var string
     */
    private $root_dir;

    /**
     * Validates that the system meets the minimum requirements
     *
     * @param  array   $request
     * @return boolean
     */
    public function validate($request = array())
    {
        $this->start();

        $error = false;

        foreach ($this->check['recommended']['values'] as $value) {
            if (substr(trim($value), 0, 2) !== 'OK') {
                $value = str_replace(array('ERROR', 'WARNING'), '', $value);
                $this->addError(sprintf('The following requirement were not met: %s', $value));
                $this->addError('Please make sure all the requirements are met before continuing with the installation');

                return false;
            }
        }

        return true;
    }

    /**
     * Not implemented
     * @param array $request
     */
    public function process($request = array()){}

    /**
     * Checks the system to make sure it meets the minimum requirements
     *
     * @return void
     */
    public function start()
    {
        $this->root_dir = $this->get('kernel')->getRootDir();

        $process = new Process(sprintf('php %s/check.php', $this->root_dir));
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $check = $process->getOutput();

        $output = explode("\n", $check);

        $recommended = $this->getOutput($output, 'mandatory requirements');
        $optional = $this->getOutput($output, 'optional recommendations');

        $this->check = array('recommended' => $recommended, 'optional' => $optional);
    }

    /**
     * Parses through the output of the system check, and extracts the requirements
     *
     * @param  array                      $output The ouput generated from the system check
     * @param  string                     $header the header to look for to get the requirements
     * @return array<string,string|array>
     */
    public function getOutput($output = array(), $header = '')
    {
        while (($line = next($output)) !== false) {
            if (strpos(strtolower($line), strtolower($header)) !== false) {
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
                } while (substr(strtolower($line), 0, 2) !== '**' && $line);
            }
        }

        return array('heading' => $heading, 'values' => $content);
    }
}
