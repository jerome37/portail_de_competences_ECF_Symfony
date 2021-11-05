<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Profile;
use App\Entity\SkillLevel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request): Response
    {
        $results = null;
        $name = $request->query->get('name');
        $skill = $request->query->get('skill');
        $level = $request->query->get('level');
        $appreciation = $request->query->get('appreciate');

        $skills = $this->em->getRepository(Skill::class)->findAll();
        $levels = $this->em->getrepository(SkillLevel::class)->findAll();

        if($name || $skill || $level || $appreciation)
        {
            $results = $this->em->getRepository(Profile::class)->searchProfiles($name, $skill, $level, $appreciation);
        }

        return $this->render("search/index.html.twig",
            [ 'results' => $results,
              'skills' => $skills,
              'levels' => $levels ]
        );
    }
}
