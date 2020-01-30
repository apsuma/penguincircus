<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    /**
     * @Route("/theme/{slug}", name="theme_index")
     */
    public function index(Theme $theme):Response
    {
        return $this->render('theme/publicIndex.html.twig', [
            'theme' => $theme,
        ]);
    }

    public function renderNavbar(ThemeRepository $themeRepo):Response
    {
        return $this->render('Blocks/_navbar.html.twig', [
            'themes' => $themeRepo->findAll()
        ]);
    }
}