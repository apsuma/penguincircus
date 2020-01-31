<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $articleRepo, EntityManagerInterface $entityManager):Response
    {
        $articles = $articleRepo->findAlaUneArticles();
        return $this->render('Home/home.html.twig', ['articles' => $articles]);
    }
}