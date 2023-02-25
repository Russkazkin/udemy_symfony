<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class AppFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $microPost = new MicroPost();
            $microPost->setText('Some random text ' . random_int(0, 100));
            $microPost->setTime(new DateTime());
            $manager->persist($microPost);
        }
        $manager->flush();
    }
}
