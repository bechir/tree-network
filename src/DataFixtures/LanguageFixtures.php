<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class LanguageFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $languages = [
            'app.lang.fr',
            'app.lang.en',
            'app.lang.ar',
            'app.lang.plr',
            'app.lang.wlf',
        ];

        foreach ($languages as $name) {
            $lang = (new Language())
                ->setName($name);
            $manager->persist($lang);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
