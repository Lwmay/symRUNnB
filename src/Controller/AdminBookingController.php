<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_booking_index")
     * @param BookingRepository $repository
     * @return Response
     */
    public function index(BookingRepository $repository)
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repository->findAll(),
        ]);
    }

    /**
     * Permet d'éditer une réservation
     *
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     *
     * @param Booking $booking
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Booking $booking, Request $request, EntityManagerInterface $manager) {
        $form = $this->createForm(AdminBookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()) {
            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                "success",
                "le réservation n° {$booking->getId()} a bien été modifiée."
            );

            return $this->redirectToRoute("admin_booking_index");
        }

        return $this->render('admin/booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    }

    /**
     * permet de supprimer une réservation
     *
     * @Route ("/admin/booking/{id}/delete", name="admin_booking_delete")
     *
     * @param Booking $booking
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete (Booking $booking, EntityManagerInterface $manager) {
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            "success",
            "la réservation a bien été supprimée."
        );

        return $this->redirectToRoute("admin_booking_index");
    }
}
