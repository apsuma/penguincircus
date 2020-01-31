<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Theme;
use App\Form\ArticleType;
use App\Repository\ThemeRepository;
use App\Service\Ago;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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

    /**
     * @Route("/theme/article/{id}", name="theme_article_show")
     */
    public function articleShow(
        Article $article,
        Ago $ago,
        Request $request,
        EntityManagerInterface $entityManager,
        UserInterface $user
    ): Response {
        $form = $this
            ->createForm(ArticleType::class, $article)
            ->remove('subject')
            ->remove('description')
            ->remove('picture')
            ->remove('inFront')
            ->remove('resaOpen')
            ->remove('authorOf')
            ->remove('showDate')
            ->remove('themes')
            ->remove('keywords')
            ->remove('favUsers')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->addFavUser($user);
            $entityManager -> flush();
            return $this -> redirectToRoute('user');
        }
        $created = $ago->diffForHumans($article->getCreatedAt());
        return $this->render('theme/publicArticle.html.twig', [
            'article' => $article,
            'created' => $created,
            'form' => $form->createView(),
        ]);
    }

    public function renderNavbar(ThemeRepository $themeRepo):Response
    {
        return $this->render('Blocks/_navbar.html.twig', [
            'themes' => $themeRepo->findAll()
        ]);
    }
}