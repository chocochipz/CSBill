<?php

namespace CS\ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CS\ClientBundle\Entity\Status;

class LoadStatus implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Active
        $active = new Status();
        $active->setName('active');
        $manager->persist($active);

        // InActive
        $in_active = new Status();
        $in_active->setName('inactive');
        $manager->persist($in_active);

        $manager->flush();
    }
}
