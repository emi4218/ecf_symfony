<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        //------------- Création des utilisateurs -------------
        $admin = new User();
        $admin->setPrenom("Emi");
        $admin->setNom("Moi");
        $admin->setEmail("emi@moi.fr");
        $admin->setPassword($this->hasher->hashPassword($admin, "moi"));
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $user = new User();
        $user->setPrenom("John");
        $user->setNom("Doe");
        $user->setEmail("john@doe.fr");
        $user->setPassword($this->hasher->hashPassword($user, "azerty"));

        $manager->persist($user);

        $manager->flush();
    }
}
