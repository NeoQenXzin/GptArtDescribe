<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('FR_fr');
        for ($i = 0; $i < 400; ++$i) {
            dump($i);
            $user = new User();
            $user->setEmail($faker->unique()->email);
            $user->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('user'));
            $manager->persist($user);

            for ($j = 0; $j < 5; ++$j) {
                $image = new Image();
                $image->setName('SkyeIsland');
                $image->setPath('https://images.unsplash.com/photo-1472214103451-9374bd1c798e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
                $image->setCreatedAt(new \DateTimeImmutable());
                $image->setUserId($user);
                $image->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
                $manager->persist($image);
            }
            if (0 === $i % 100) {
                $manager->flush();
            }
        }

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('admin'));
        $manager->persist($admin);
        $manager->flush();
    }
}
