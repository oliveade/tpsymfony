<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DishController extends AbstractController
{
    #[Route('/create-dishes', name: 'create_dishes')]
    public function createDishes(EntityManagerInterface $entityManager): Response
    {
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

            $entityManager->persist($dish);
        }

        $entityManager->flush();

        return new Response('Dishes created successfully');
    }
}
