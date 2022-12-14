<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        /* $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setPassword('$2y$13$jW.o9XxlQ.NX1Uv.YyJhHO0Lzqjuor3wJbXFeUzI2MjKycuC0pHWC');
        $manager->persist($user);
        */

        /* for ($i=1; $i<=100; $i++){
            $product = new Product();
            $product->setName('lorem ipsum '.$i);
            $product->setSlug('lorem-ipsum-'.$i);
            $product->setDescription('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas officiis consectetur voluptate? Nisi distinctio pariatur, similique in minus perferendis sunt tenetur blanditiis. Enim dolorum optio porro molestiae laboriosam architecto facilis?');
            $manager->persist($product);
        } */

        
        /* for ($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setName('Category '.$i);
            $category->setSlug('category-'.$i);
            $category->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, distinctio. Exercitationem provident at, amet possimus voluptatem sed illum consequatur adipisci, veritatis nihil consequuntur maxime, officia culpa nobis aliquid nemo voluptates!');
            
            $manager->persist($category);
        } */

        $manager->flush();
    }
}
