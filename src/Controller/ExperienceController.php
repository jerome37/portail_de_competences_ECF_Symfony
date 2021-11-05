<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Experience;
use App\Form\ExperienceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExperienceController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/experience", name="experience")
     */
    public function index(): Response
    {
        $experiences = $this->em->getRepository(Experience::class)->findAll();
        
        return $this->render('experience/index.html.twig', [
            'experiences' => $experiences,
        ]);
    }

    /**
     * @Route("experience/add", name="add_experience")
     */
    public function addExperience(Request $request)
    {
        $experience = new Experience;
        $addExperienceForm = $this->createForm(ExperienceType::class, $experience);

        $addExperienceForm->handleRequest($request);

        if($addExperienceForm->isSubmitted() && $addExperienceForm->isValid())
        {
            $experience = $addExperienceForm->getData();

            $id = $request->query->get('id');
            $profile = $this->em->getRepository(Profile::class)->findBy(['id' => $id]);
            $experience->setProfile($profile[0]);

            $this->em->persist($experience);
            $this->em->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('experience/add.html.twig', 
            [ 'add_experience_form' => $addExperienceForm->createView() ]
        );
    }

    /**
     * @Route("experience/modify/{id}", name="modify_experience")
     */
    public function modifyExperience(Experience $id, Request $request): Response 
    {
        $modifyExperienceForm = $this->createForm(ExperienceType::class, $id);

        $modifyExperienceForm->handleRequest($request);

        if($modifyExperienceForm->isSubmitted() && $modifyExperienceForm->isValid())
        {
            $id = $modifyExperienceForm->getData();

            $this->em->persist($id);
            $this->em->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('experience/modify.html.twig', 
            [ 'modify_experience_form' => $modifyExperienceForm->createView() ]
        );
    }

    /**
     * @Route("experience/delete/{id}", name="delete_experience")
     */
    public function deleteExperience(Experience $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('experience');
    }
}
