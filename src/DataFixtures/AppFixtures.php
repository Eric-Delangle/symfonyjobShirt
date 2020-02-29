<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Products;
use Doctrine\Migrations\Version\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker =  Faker\Factory::create('fr_FR');
        $categories = [];
        $users = [];
        $product = [];
        
        $cat = ['homme', 'femme', 'accessoires'];
        foreach($cat as $name){
            $category = new Category();
            $category->setName($name);   
            $category->setRegistredAt($faker ->dateTimeBetween($startDate = '-6 months', $endDate = 'now'));
            $manager->persist($category);
            $categories[] = $category;
        }
        

        for ($h = 0; $h <= 15; $h++) {
                
            $user = new User();
            $user->setFirstName($faker->firstNameMale());
            $user->setLastName($faker->lastName());
            $user->setEmail("email+".$h."@email.com");
            $user->setPassword("password");
            $user->setNiveau(1);
            $user->setRegisteredAt($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'));
            $users[] = $user;
            $manager->persist($user);
        }

        for ($i = 0; $i <= 15; $i++) {
                
            $prod = new Products();
            $prod->setName($faker->name());
            $prod->setDescription($faker->text());
            $prod->setPrice($faker->randomDigit());
            $prod->setPicture('sweet homme.png');
            $prod->setPictureFile(new File('public/images/products/sweet homme.png'));
            
            
            foreach ($categories as $category) {
                $prod->addCategory($category->addArticle($prod));
                $prod->setRegisteredAt($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'));
            }
               
            
           
            $product[] = $prod;
            $manager->persist($prod);

        }
           
            $manager ->flush(); 
    }
}
