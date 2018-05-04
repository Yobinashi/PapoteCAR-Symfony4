<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 30/04/2018
 * Time: 17:00
 */

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Member;
use App\Entity\Run;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class FakerFixtures extends Fixture implements FixtureInterface
{

    protected $em;

    public function __construct()
    {

    }

    public function load(ObjectManager $manager)
    {
        $cityTab = ["Nantes","Tours","Paris", "Angers", "Lyon", "Marseille", "Toulouse", "Toulon", "Brest", "Avignon"];

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 100 personnes
        for ($i = 0; $i < 100; $i++) {
            // member
            $member = new Member();
            $member->setFirstname($faker->firstName);
            $member->setLastname($faker->lastName);
            $member->setEmail($faker->email);
            $member->setPassword($faker->password);
            //$encoded= $enc->encodePassword($member, $registerForm->get('password')->getData());
            //$member->setPassword($encoded);
            $member->setTel(0000000000);
            $member->setPicture($faker->imageUrl(400,400,"people"));
            $member->setVehicle($faker->text);
            $member->setRoles(["ROLE_USER"]);
            //$member->setComments($faker->realText(1000));

            $manager->persist($member);

            // comment
            $comment = new Comment();
            $comment->setContent($faker->realText());
            $comment->setWriter($member);
            $comment->setTarget($member);
            $comment->setNote($faker->numberBetween($min = 1, $max = 5));

            $manager->persist($comment);

            // city
            $city = new City();
            $city->setZipcode($faker->numberBetween($min = 10000, $max = 99999));
            //$city->setCityName($faker->city(3));
            // permet d'afficher aléatoirement une ville sélectionnée dans le tableau
            $nbRand = rand(0,9);
            shuffle($cityTab);
            $city->setCityName($cityTab[$nbRand]);

            $manager->persist($city);

            // run
            $run = new Run();
            $run->setDriver($member);
            $run->setPlaces($faker->numberBetween($min = 1, $max = 5));
            $run->setPrice($faker->randomFloat(2,10,200));
            $run->setDeparture($city);
            $run->setArrival($city);
            $run->setDepartureSchedule($faker->dateTime('now',null));

            $manager->persist($run);
        }

        $manager->flush();
    }

    // installer faker:
    //-> composer req --dev make doctrine/doctrine-fixtures-bundle
    //-> composer req --dev fzaninotto/faker
    // pour lancer faker:
    //-> php bin/console doctrine:fixtures:load




}