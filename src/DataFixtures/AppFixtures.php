<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
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
        $faker = Faker\Factory::create();

        $tableauImage = ["image1.jpg", "image2.jpg", "image3.jpg", "image4.jpg", "image5.jpg", "image6.jpg", "image7.jpg", "image8.jpg"];


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

        $user2 = new User();
        $user2->setPrenom("Bill");
        $user2->setNom("Boquet");
        $user2->setEmail("bill@boquet.fr");
        $user2->setPassword($this->hasher->hashPassword($user2, "boquet"));

        $manager->persist($user2);

        $listeUsers = [
            $admin,
            $user,
            $user2,
        ];


        //------------- Création d'articles -------------

        for ($i = 0; $i < 12; $i++) {
            $article = new Article();
            $article->setTitre($faker->sentence(3))
                ->setDescription($faker->text(2500))
                ->setImage($faker->randomElement($tableauImage))
                ->setAuteur($faker->randomElement($listeUsers))
                ->setDate($faker->dateTimeBetween('-1 month'));

            $nombreCommentaire = $faker->numberBetween(0, 3);

            for ($j = 0; $j < $nombreCommentaire; $j++) {
                $commentaire = new Commentaire();
                $commentaire->setAuteur($faker->randomElement($listeUsers))
                    ->setDateCommentaire($faker->dateTimeBetween('-1 month'))
                    ->setTexteCommentaire($faker->text(200))
                    ->setComArticle($article);

                $manager->persist($commentaire);
            }

            $manager->persist($article);
        }


        $manager->flush();
    }
}
