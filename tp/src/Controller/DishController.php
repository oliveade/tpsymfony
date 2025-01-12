<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DishController extends AbstractController
{
    #[Route('/dishes', name: 'app_dish_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $dishes = $em->getRepository(Dish::class)->findAll();
        return $this->render('dish/list.html.twig', ['dishes' => $dishes]);
    }

    #[Route('/dishes/create', name: 'app_dish_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $dish = new Dish();

        if ($request->isMethod('POST')) {
            $dish->setName($request->request->get('name'));
            $dish->setDescription($request->request->get('description'));
            $dish->setPrice($request->request->get('price'));
            $dish->setCreatedAt(new \DateTimeImmutable());
            $dish->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($dish);
            $em->flush();
            return $this->redirectToRoute('app_dish_list');
        }

        return $this->render('dish/create.html.twig');
    }

    #[Route('/dishes/edit/{id}', name: 'app_dish_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $dish = $em->getRepository(Dish::class)->find($id);
        if (!$dish) {
            throw $this->createNotFoundException('Plat non trouvé');
        }

        if ($request->isMethod('POST')) {
            $dish->setName($request->request->get('name'));
            $dish->setDescription($request->request->get('description'));
            $dish->setPrice($request->request->get('price'));
            $dish->setCreatedAt(new \DateTimeImmutable());
            $dish->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            return $this->redirectToRoute('app_dish_list');
        }

        return $this->render('dish/edit.html.twig', ['dish' => $dish]);
    }

    #[Route('/dishes/delete/{id}', name: 'app_dish_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $dish = $em->getRepository(Dish::class)->find($id);
        if ($dish) {
            $em->remove($dish);
            $em->flush();
        }

        return $this->redirectToRoute('app_dish_list');
    }
}
