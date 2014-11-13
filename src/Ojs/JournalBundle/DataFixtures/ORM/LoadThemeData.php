<?php

namespace Ojs\JournalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ojs\JournalBundle\Entity\Theme;

class LoadThemeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $theme = new Theme();
        $theme->setName("default");
        $manager->persist($theme);
        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }

}
