<?php

namespace CS\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CS\UserBundle\Entity\Role;


class LoadRoles implements FixtureInterface {
	
	public function load(ObjectManager $manager)
    {
        $super_admin = new Role();
        $super_admin->setName('super_admin');
        $super_admin->setRole('ROLE_SUPER_ADMIN');

        $manager->persist($super_admin);
        $manager->flush();
    }
}
