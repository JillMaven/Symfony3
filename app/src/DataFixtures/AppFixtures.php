<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Categories;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();
        $userAdmin->setEmail("valentin.freville97+admin@gmail.com");

        $password = $this->hasher->hashPassword($userAdmin, 'passwordAdmin');
        $userAdmin->setPassword($password);

        $userAdmin->setUsername("Admin");
        $userAdmin->setFirstName("Valentin");
        $userAdmin->setLastName("FREVILLE");
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setIsVerified(true);

        $manager->persist($userAdmin);

        $user = new User();
        $user->setEmail("valentin.freville97@gmail.com");

        $password = $this->hasher->hashPassword($user, 'passwordUser');
        $user->setPassword($password);

        $user->setUsername("User");
        $user->setFirstName("Valentin");
        $user->setLastName("FREVILLE");
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(true);

        $manager->persist($user);

        $category = new Categories();
        $category->setName("Saucisse");

        $manager->persist($category);

         // create 20 products! Bam!
         for ($i = 0; $i < 1000; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setSlug('product_'.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setQuantity(mt_rand(1,15));
            $product->setDescription('Ceci est le produit '.$i);
            $product->setIsNewArrival(true);
            $product->setImage('');
            $manager->persist($product);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
