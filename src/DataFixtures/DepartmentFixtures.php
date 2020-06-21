<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Department;
use Faker\Factory;

class DepartmentFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        # Création des fakers et de la boucle pour générer 5 Departements.
        $faker = Factory::create();
        for($i = 0 ; $i < 5 ; $i++){

            # Création du model département et appel des fakers.
            $department = new Department();
            $department->setName($faker->city);
            $department->setCapacity($faker->randomElement($array = array ('100','150','200')));

            #Création d'une référence et enregistrement des données.
            $this -> addReference('department'.$i, $department);
            $manager->persist($department);
        } 
        $manager->flush();
    }
    public function getOrder(){
    	return 1;
    }
}