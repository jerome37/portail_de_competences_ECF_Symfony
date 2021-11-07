<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        
        $role = $user->getRoles()[0];

        return $this->render('home/index.html.twig', [
            'role' => $role,
        ]);
    }
}
