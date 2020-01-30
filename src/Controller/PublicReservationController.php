<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PublicReservationController extends AbstractController
{

    /**
     * @Route("/public/mareservation", name="public_reservation", methods={"GET","POST"})
     */
    public function ResaForMyColony(
        Request $request,
        EntityManagerInterface $entityManager,
        UserInterface $user
     ): Response {
        $reservation = new Reservation();
        $form = $this
            -> createForm(ReservationType::class, $reservation)
            -> remove('createdAt')
            -> remove('user')
            -> remove('accepted')
        ;
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            $reservation -> setUser($user);
            $entityManager -> persist($reservation);
            $entityManager -> flush();
            $this -> addFlash(
                'success',
                'Votre demande de réservation a bien été prise en compte. Penguin Circus la traite et revient vers vous !'
            );
            return $this -> redirectToRoute('home');
        }
        return $this->render('reservation/mareservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }
}