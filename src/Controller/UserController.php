<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(UserInterface $user) : Response
    {
        if ($this->getUser()){
            $user = new User();
            $user = $this->getUser();
            return $this->render('user/index.html.twig', [
                'user' => $user
        ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
