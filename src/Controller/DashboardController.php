<?php

namespace App\Controller;

use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        $newCandidates = $this->em->getRepository(Profile::class)->getNewCandidates();
        
        $newCollaborators = $this->em->getRepository(Profile::class)->getNewCollaborators();

        $modifiedProfiles = $this->em->getRepository(Profile::class)->getModifiedProfiles();
        
        return $this->render('dashboard/index.html.twig',[ 
            'new_candidates' => $newCandidates,
            'new_collaborators' => $newCollaborators,
            'modified_profiles' => $modifiedProfiles 
        ]);
    }
}
