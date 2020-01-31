<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use App\Service\Sluger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/theme", name="admin_theme")
 */
class AdminThemeController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(ThemeRepository $themeRepository): Response
    {
        return $this->render('theme/index.html.twig', [
            'themes' => $themeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Sluger $sluger
    ): Response {
        $theme = new Theme();
        $form = $this
            ->createForm(ThemeType::class, $theme)
            ->remove('slug')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modify = $sluger->modifyName($theme->getName());
            $theme->setSlug($modify);
            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('admin_theme_index');
        }

        return $this->render('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="_show", methods={"GET"})
     */
    public function show(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Theme $theme,
        Sluger $sluger,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this
            ->createForm(ThemeType::class, $theme)
            ->remove('slug')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modify = $sluger->modifyName($theme->getName());
            $theme->setSlug($modify);
            $entityManager->flush();

            return $this->redirectToRoute('admin_theme_index');
        }

        return $this->render('theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Theme $theme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_theme_index');
    }
}
