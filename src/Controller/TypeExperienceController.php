<?php

namespace App\Controller;

use App\Entity\TypeExperience;
use App\Form\TypeExperienceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeExperienceController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/type/experience", name="type_experience")
     */
    public function index(): Response
    {
        $exeperienceTypes = $this->em->getRepository(TypeExperience::class)->findAll();
        
        return $this->render('type_experience/index.html.twig', [
            'experience_types' => $exeperienceTypes,
        ]);
    }

    /**
     * @Route("type/experience/add", name="add_type_experience")
     */
    public function addType(Request $request): Response 
    {
        $experienceType = New TypeExperience;
        $addExperienceTypeForm = $this->createForm(TypeExperienceType::class, $experienceType);

        $addExperienceTypeForm->handleRequest($request);

        if($addExperienceTypeForm->isSubmitted() && $addExperienceTypeForm->isValid())
        {
            $experienceType = $addExperienceTypeForm->getData();

            $this->em->persist($experienceType);
            $this->em->flush();

            return $this->redirectToRoute('type_experience');
        }

        return $this->render('type_experience/add.html.twig',
            [ 'add_experience_type_form' => $addExperienceTypeForm->createView() ]
        );
    }

    /**
     * @Route("type/experience/modify/{id}", name="modify_type_experience")
     */
    public function modifyType(TypeExperience $id, Request $request): Response 
    {
        $modifyExperienceTypeForm = $this->createForm(TypeExperienceType::class, $id);

        $modifyExperienceTypeForm->handleRequest($request);

        if($modifyExperienceTypeForm->isSubmitted() && $modifyExperienceTypeForm->isValid())
        {
            $experienceType = $modifyExperienceTypeForm->getData();

            $this->em->persist($experienceType);
            $this->em->flush();

            return $this->redirectToRoute('type_experience');
        }

        return $this->render('type_experience/modify.html.twig', 
            [ 'modify_experience_type_form' => $modifyExperienceTypeForm->createView() ]
        );
    }

    /**
     * @Route("type/experience/delete/{id}", name="delete_type_experience")
     */
    public function deleteType(TypeExperience $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('type_experience');
    }
}
