<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Restaurant;



class UserController extends AbstractController
{
    #[Route('/user', name: 'app_profile')]
    public function maPage(DishRepository $dishRepository): Response
    {
        $dishes = $dishRepository->findAll();

        return $this->render('user.html.twig', [
            'dishes' => $dishes,
        ]);
    }
    #[Route('/userPage', name: 'app_user_page')]
    public function userPage(): Response
    {
        return $this->render('/profile.html.twig');
    }

    #[Route('/userReservation', name: 'app_reservation')]
    public function userReservation(): Response
    {
        return $this->render('/reservation.html.twig');
    }
    #[Route('/reservation-success', name: 'app_reservation_success')]
    public function reservationSuccess(): Response
    {
        return $this->render('reservation/success.html.twig');
    }
    #[Route('/addReservation', name: 'app_reservation_submit', methods: ['POST'])]
    public function addReservation(Request $request, EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();

        $reservation->setReservationDate(new \DateTime($request->request->get('reservation_date')));
        $reservation->setNumberOfPeople((int) $request->request->get('number_of_people'));
        $reservation->setStatus('En attente');
        $reservation->setCreatedAt(new \DateTimeImmutable());
        $reservation->setUpdatedAt(new \DateTimeImmutable());

        $restaurant = $em->getRepository(Restaurant::class)->find(1);
        if ($restaurant) {
            $reservation->setRestaurant($restaurant);
        }

        $em->persist($reservation);
        $em->flush();

        return $this->redirectToRoute('app_reservation_success');
    }
    #[Route('/users', name: 'app_user_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();
        return $this->render('user/list.html.twig', ['users' => $users]);
    }

    #[Route('/users/create', name: 'app_user_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();

        if ($request->isMethod('POST')) {
            $user->setFirstname($request->request->get('firstname'));
            $user->setLastname($request->request->get('lastname'));
            $user->setEmail($request->request->get('email'));
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/create.html.twig');
    }

    #[Route('/users/edit/{id}', name: 'app_user_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        if ($request->isMethod('POST')) {
            $user->setFirstname($request->request->get('firstname'));
            $user->setLastname($request->request->get('lastname'));
            $user->setEmail($request->request->get('email'));
            $em->flush();
            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/edit.html.twig', ['user' => $user]);
    }

    #[Route('/users/delete/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        if ($user) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('app_user_list');
    }
}
