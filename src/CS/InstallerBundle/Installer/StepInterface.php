<?php

namespace CS\InstallerBundle\Installer;

interface StepInterface
{
    public function getData();

    public function validate($request = array());

    public function process($request = array());

    public function start();
}
