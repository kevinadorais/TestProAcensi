<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Student;
use Faker\Factory;

class StudentFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        # Création des fakers et de la boucle pour générer 100 Students.
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++) {

             # Création du model Student et appel des fakers.
            $student = new Student();
            $student->setFirstName($faker->firstName);
            $student->setLastName($faker->lastName);
            $student->setNumEtud($faker->randomElement($array = array ('0620406080','0710305070','0680604020', '0725457595', '0622448866')));
            $student->setDepartment($this->getReference('department'.rand(0, 4)));

            #Enregistrement des données.
            $manager->persist($student);
        }
        $manager->flush();
    }
    public function getOrder(){
    	return 2;
    }
}