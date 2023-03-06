<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Automobiles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create and persist 3 automobiles
        $automobile1 = new Automobiles();
        $automobile1->setBrand('Honda');
        $automobile1->setModel('Civic');
        $automobile1->setYear('2017');
        $automobile1->setTo100InSec(7.0);
        $manager->persist($automobile1);

        $automobile2 = new Automobiles();
        $automobile2->setBrand('Porsche');
        $automobile2->setModel('Cayman');
        $automobile2->setYear('2013');
        $automobile2->setTo100InSec(5.6);
        $manager->persist($automobile2);

        $automobile3 = new Automobiles();
        $automobile3->setBrand('Mercedes-Benz');
        $automobile3->setModel('E63 AMG');
        $automobile3->setYear('2016');
        $automobile3->setTo100InSec(3.4);
        $manager->persist($automobile3);

        $automobile4 = new Automobiles();
        $automobile4->setBrand('Audi');
        $automobile4->setModel('RS3');
        $automobile4->setYear('2021');
        $automobile4->setTo100InSec(3.8);
        $manager->persist($automobile4);

        $manager->flush();
    }
}
