<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $event->setName('Concert 1');
        $event->setDescription('Lorem');
        $event->setPrice(10 * 100);
        $event->setStartAt(new \DateTimeImmutable('2023-03-14 11:38:45'));
        $event->setEndAt(new \DateTimeImmutable('2023-03-15 11:38:45'));
        $manager->persist($event);

        $event = new Event();
        $event->setName('Concert 2');
        $event->setDescription('Lorem');
        $event->setPrice(20 * 100);
        $event->setStartAt(new \DateTimeImmutable('2023-03-16 10:38:45'));
        $event->setEndAt(new \DateTimeImmutable('2023-03-18 11:38:45'));
        $manager->persist($event);

        $event = new Event();
        $event->setName('Concert 3');
        $event->setDescription('Lorem');
        $event->setPrice(30 * 100);
        $event->setStartAt(new \DateTimeImmutable('2023-03-18 11:38:45'));
        $event->setEndAt(new \DateTimeImmutable('2023-03-19 11:38:45'));
        $manager->persist($event);

        $manager->flush();
    }
}
