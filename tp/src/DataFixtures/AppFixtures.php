<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Dish;
use App\Entity\Restaurant;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        $admin = new User();
        $admin->setFirstName('test1')
            ->setLastName('Dupont')
            ->setEmail('test1@admin.com')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT))
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($admin);

        $user = new User();
        $user->setFirstName('test2')
            ->setLastName('Machin')
            ->setEmail('test2@example.com')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT))
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($user);

        $bannedUser = new User();
        $bannedUser->setFirstName('test3')
            ->setLastName('Truc')
            ->setEmail('test3@banned.com')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT))
            ->setRoles(['ROLE_BANNED'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($bannedUser);


        $restaurant = new Restaurant();
        $restaurant->setName('Restaurant Symphony');
        $restaurant->setAddress('123 Rue de Paris, 75000 Paris');
        $restaurant->setPhone('01 23 45 67 89');
        $restaurant->setEmail('contact@restaurantexemple.com');
        $restaurant->setDescription('Un restaurant qui offre une cuisine délicieuse avec une ambiance conviviale.');
        $restaurant->setCreatedAt(new \DateTimeImmutable());
        $restaurant->setUpdatedAt(new \DateTimeImmutable());

        $manager->persist($restaurant);

        $dishes = [
            ['name' => 'Salade César', 'description' => 'Une salade classique avec du poulet, de la laitue et des croûtons.', 'price' => 10.0],
            ['name' => 'Bruschetta', 'description' => 'Pain grillé garni de tomates fraîches et d\'ail.', 'price' => 8.0],
            ['name' => 'Soupe du Jour', 'description' => 'Une soupe délicieuse et réconfortante, changeant chaque jour.', 'price' => 7.0],
            ['name' => 'Poulet Rôti', 'description' => 'Poulet rôti juteux et savoureux, servi avec des légumes.', 'price' => 15.0],
            ['name' => 'Filet de Saumon', 'description' => 'Saumon grillé servi avec une sauce à l\'aneth.', 'price' => 18.0],
            ['name' => 'Pâtes Carbonara', 'description' => 'Pâtes avec une sauce crémeuse au lard et au parmesan.', 'price' => 14.0],
            ['name' => 'Tarte Tatin', 'description' => 'Tarte aux pommes caramélisées, servie tiède.', 'price' => 6.0],
            ['name' => 'Crème Brûlée', 'description' => 'Dessert crémeux avec une croûte de sucre caramélisé.', 'price' => 5.0],
            ['name' => 'Mousse au Chocolat', 'description' => 'Mousse légère et aérienne au chocolat noir.', 'price' => 6.0],
            ['name' => 'Vin Rouge', 'description' => 'Sélection de vins rouges fins.', 'price' => 20.0],
            ['name' => 'Bière Artisanale', 'description' => 'Bière artisanale locale, rafraîchissante.', 'price' => 5.0],
            ['name' => 'Jus de Fruits Frais', 'description' => 'Jus de fruits frais et naturels.', 'price' => 4.0],
        ];

        foreach ($dishes as $data) {
            $dish = new Dish();
            $dish->setName($data['name']);
            $dish->setDescription($data['description']);
            $dish->setPrice($data['price']);
            $dish->setCreatedAt(new \DateTimeImmutable());
            $dish->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($dish);
        }

        $manager->flush();
    }
}
