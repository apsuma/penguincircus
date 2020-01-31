<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ArticleRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
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
            $reservation->setUser($this->getUser());
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
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $isConfirmed = $reservation->getAccepted();
        $form = $this
            ->createForm(ReservationType::class, $reservation)
            ->remove('createdAt')
            ->remove('user')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nbPlace = $reservation->getNbPlaceAdult() +  $reservation->getNbPlaceChild();
            $evtplace = $reservation->getArticles()->getPlacesLeft();
            if ($reservation->getAccepted() != $isConfirmed AND $reservation->getAccepted() == true) {
                $evtplace = $evtplace - $nbPlace;
            } elseif ($reservation->getAccepted() != $isConfirmed AND $reservation->getAccepted() == false) {
                $evtplace = $evtplace + $nbPlace;
            }
            $reservation->getArticles()->setPlacesLeft($evtplace);
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
