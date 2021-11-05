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
        // dd($user);

        $role = $user->getRoles()[0];
        // dd($role);

        return $this->render('home/index.html.twig', [
            'role' => $role,
        ]);
    }
}
