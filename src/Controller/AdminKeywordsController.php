<?php

namespace App\Controller;

use App\Entity\Keywords;
use App\Form\KeywordsType;
use App\Repository\KeywordsRepository;
use App\Service\Sluger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/keywords", name="admin_keywords")
 */
class AdminKeywordsController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(KeywordsRepository $keywordsRepository): Response
    {
        return $this->render('keywords/index.html.twig', [
            'keywords' => $keywordsRepository->findAll(),
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
        $keyword = new Keywords();
        $form = $this
            ->createForm(KeywordsType::class, $keyword)
            ->remove('slug')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modify = $sluger->modifyName($keyword->getName());
            $keyword->setSlug($modify);
            $entityManager->persist($keyword);
            $entityManager->flush();

            return $this->redirectToRoute('admin_keywords_index');
        }

        return $this->render('keywords/new.html.twig', [
            'keyword' => $keyword,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="_show", methods={"GET"})
     */
    public function show(Keywords $keyword): Response
    {
        return $this->render('keywords/show.html.twig', [
            'keyword' => $keyword,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Sluger $modifyKeyword,
        Keywords $keyword,
        EntityManagerInterface $em
    ): Response {
        $form = $this
            ->createForm(KeywordsType::class, $keyword)
            ->remove('slug')
            ->remove('articles')
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modify= $modifyKeyword->modifyName($keyword->getName());
            $keyword->setSlug($modify);
            $em->flush();
            return $this->redirectToRoute('admin_keywords_index');
        }

        return $this->render('keywords/edit.html.twig', [
            'keyword' => $keyword,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Keywords $keyword): Response
    {
        if ($this->isCsrfTokenValid('delete'.$keyword->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($keyword);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_keywords_index');
    }
}
