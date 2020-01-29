<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/reservation", name="admin_reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        User $user,
        Article $article
        ): Response {
        $reservation = new Reservation();
        $form = $this
            ->createForm(ReservationType::class, $reservation)
            ->remove('createdAt')
            ->remove('user')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setUser($user);
            $reservation->setArticles($article);
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Reservation $reservation,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this
            ->createForm(ReservationType::class, $reservation)
            ->remove('createdAt')
            ->remove('user')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->flush();

            return $this->redirectToRoute('admin_reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_reservation_index');
    }
}
