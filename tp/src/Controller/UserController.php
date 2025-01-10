<?php

Namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractController
{
    #[Route('/user', name:'app_profile')]
    public function maPage(DishRepository $dishRepository): Response
    {
        $dishes = $dishRepository->findAll();

        return $this->render('user.html.twig', [
            'dishes' => $dishes,
        ]);
    }
    #[Route('/userPage', name:'app_user_page')]
    public function userPage(): Response
    {
        return $this->render('/profile.html.twig');
    }

    #[Route('/userReservation', name:'app_reservation')]
    public function userReservation(): Response
    {
        return $this->render('/reservation.html.twig');
    }

    #[Route('/addReservation', name:'app_reservation_submit')]
    public function addReservation(Request $request): Response
    {
        dd($request->request->all());
    }
}