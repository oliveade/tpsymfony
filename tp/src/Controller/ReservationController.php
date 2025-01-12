<?php
namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservations', name: 'app_reservation_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $reservations = $em->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/list.html.twig', ['reservations' => $reservations]);
    }

    #[Route('/reservations/create', name: 'app_reservation_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();

        if ($request->isMethod('POST')) {
            $reservation->setReservationDate(new \DateTime($request->request->get('reservation_date')));
            $reservation->setNumberOfPeople($request->request->get('number_of_people'));
            $reservation->setStatus($request->request->get('status'));

            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('app_reservation_list');
        }

        return $this->render('reservation/create.html.twig');
    }

    #[Route('/reservations/edit/{id}', name: 'app_reservation_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $reservation = $em->getRepository(Reservation::class)->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException('Réservation non trouvée');
        }

        if ($request->isMethod('POST')) {
            $reservation->setReservationDate(new \DateTime($request->request->get('reservation_date')));
            $reservation->setNumberOfPeople($request->request->get('number_of_people'));
            $reservation->setStatus($request->request->get('status'));

            $em->flush();
            return $this->redirectToRoute('app_reservation_list');
        }

        return $this->render('reservation/edit.html.twig', ['reservation' => $reservation]);
    }

    #[Route('/reservations/delete/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $reservation = $em->getRepository(Reservation::class)->find($id);
        if ($reservation) {
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('app_reservation_list');
    }
}
