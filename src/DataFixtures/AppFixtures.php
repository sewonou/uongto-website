<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * Encodeur de mot de passe
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $role = new Role();
        $role->setTitle('ROLE_ADMIN');
        $manager->persist($role);

        for ($i = 0; $i < 5 ; $i++){
            $user = new User();
            $hash = $this->encoder->hashPassword($user, "password");
            $user->setUsername($faker->userName)
                ->setPassword($hash)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPicture('/app-assets/images/portrait/small/avatar-s-'.mt_rand(1, 26).'.png')
                ->setEmail($faker->email)
                ->addUserRole($role)
            ;
            $manager->persist($user);
        }

        for ($i = 0; $i < 15 ; $i++){
            $user = new User();
            $hash = $this->encoder->hashPassword($user, "password");
            $user->setUsername($faker->userName)
                ->setPassword($hash)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPicture('/app-assets/images/portrait/small/avatar-s-'.mt_rand(1, 26).'.png')
            ;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
