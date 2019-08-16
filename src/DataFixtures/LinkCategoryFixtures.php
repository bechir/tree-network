<?php

namespace App\DataFixtures;

use App\Entity\Gender;
use App\Entity\LinkCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LinkCategoryFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $maleCategories = [
            ['word.father'          => 'word.son'],
            ['word.brother'         => 'word.brother'],
            ['word.uncle'           => 'word.nephew'],
            ['word.son'             => 'word.father'],
            ['word.husband'         => 'word.wife'],
            ['word.grand_father'    => 'word.inv_grand_father'],
            ['word.stepfather'      => 'word.stepchild'],
            ['word.stepchild'       => 'word.stepfather'],
            ['word.half_brother'    => 'word.half_brother'],
            ['word.brother_in_law'  => 'word.inv_brother_in_law'],
            ['word.friend'          => 'word.friend'],
            ['word.cousin'          => 'word.cousin'],
            ['word.nephew'          => 'word.uncle'],
        ];

        $femaleCategories = [
            ['word.mother'          => 'word.daughter'],
            ['word.sister'          => 'word.sister'],
            ['word.aunt'            => 'word.niece'],
            ['word.daughter'        => 'word.mother'],
            ['word.wife'            => 'word.husband'],
            ['word.grand_mother'    => 'word.inv_grand_monther'],
            ['word.stepmother'      => 'word.stepdaughter'],
            ['word.stepdaughter'    => 'word.stepmother'],
            ['word.half_sister'     => 'word.half_sister'],
            ['word.sister_in_law'   => 'word.inv_sister_in_law'],
            ['word.m_friend'        => 'word.m_friend'],
            ['word.m_cousin'        => 'word.m_cousin'],
            ['word.niece'           => 'word.aunt'],
        ];

        $maleGender = $manager->getRepository(Gender::class)->findOneByName('word.male');
        $femaleGender = $manager->getRepository(Gender::class)->findOneByName('word.female');

        foreach ($maleCategories as $category) {
            foreach ($category as $name => $inverse) {
                $category = (new LinkCategory())
                    ->setName($name)
                    ->setInverse($inverse)
                    ->setGender($maleGender);

                $manager->persist($category);
            }
        }

        foreach ($femaleCategories as $category) {
            foreach ($category as $name => $inverse) {
                $category = (new LinkCategory())
                    ->setName($name)
                    ->setInverse($inverse)
                    ->setGender($femaleGender);

                $manager->persist($category);
            }
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }

    public function getDependencies()
    {
        return [
            GenderFixtures::class,
        ];
    }
}
