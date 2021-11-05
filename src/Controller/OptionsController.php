<?php

namespace App\Controller;

use App\Entity\SkillLevel;
use App\Entity\TypeDocument;
use App\Form\SkillLevelType;
use App\Entity\TypeExperience;
use App\Form\TypeDocumentType;
use App\Form\TypeExperienceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OptionsController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/options", name="options")
     */
    public function index(): Response 
    {
        $skillLevels = $this->em->getRepository(SkillLevel::class)->findAll();

        $experienceTypes = $this->em->getRepository(TypeExperience::class)->findAll();

        $documentTypes = $this->em->getRepository(TypeDocument::class)->findAll();

        return $this->render('options/index.html.twig', [
            'skill_levels' => $skillLevels,
            'experience_types' => $experienceTypes,
            'document_types' => $documentTypes,
        ]);
    }

    /**
     * @Route("/options/add", name="add_options")
     */
    public function addOptions(Request $request): Response
    {
        
        $skillLevel = new SkillLevel;
        $addSkillLevelForm = $this->createForm(SkillLevelType::class, $skillLevel);

        $addSkillLevelForm->handlerequest($request);

        if($addSkillLevelForm->isSubmitted() && $addSkillLevelForm->isValid())
        {
            $skillLevel = $addSkillLevelForm->getData();

            $this->em->persist($skillLevel);
            $this->em->flush();
            
            return $this->redirectToRoute('options');
        }

        $experienceType = New TypeExperience;
        $addExperienceTypeForm = $this->createForm(TypeExperienceType::class, $experienceType);

        $addExperienceTypeForm->handleRequest($request);

        if($addExperienceTypeForm->isSubmitted() && $addExperienceTypeForm->isValid())
        {
            $experienceType = $addExperienceTypeForm->getData();

            $this->em->persist($experienceType);
            $this->em->flush();

            return $this->redirectToRoute('options');
        }


        $documentType = new TypeDocument;
        $addDocumentTypeForm = $this->createForm(TypeDocumentType::class, $documentType);

        $addDocumentTypeForm->handleRequest($request);

        if($addDocumentTypeForm->isSubmitted() && $addDocumentTypeForm->isValid())
        {
            $documentType = $addDocumentTypeForm->getData();

            $this->em->persist($documentType);
            $this->em->flush();

            return $this->redirectToRoute('options');
        }
        
        return $this->render('options/add.html.twig', [
            'add_skill_level' => $addSkillLevelForm->createView(),
            'add_experience_type' => $addExperienceTypeForm->createView(),
            'add_document_type' => $addDocumentTypeForm->createView()
        ]);
    }

    /**
     * @Route("/options/modify/{id}", name="modify_options")
     */
    public function modifyOptions(?SkillLevel $skillLevelId, ?TypeExperience $typeExperienceId, ?TypeDocument $documentTypeId, Request $request): Response 
    {
        $skillLevel = new SkillLevel;
        $modifySkillLevelForm = $this->createForm(SkillLevelType::class, $skillLevelId);
        $modifySkillLevelForm->handleRequest($request);
        if($modifySkillLevelForm->isSubmitted() && $modifySkillLevelForm->isValid())
        {
            $id = $modifySkillLevelForm->getData();

            $this->em->persist($id);
            $this->em->flush();

            return $this->redirectToRoute('options');
        };
        
        $experienceType = new TypeExperience;
        $modifyExperienceTypeForm = $this->createForm(TypeExperienceType::class, $typeExperienceId);
        $modifyExperienceTypeForm->handleRequest($request);
        if($modifyExperienceTypeForm->isSubmitted() && $modifyExperienceTypeForm->isValid())
        {
            $experienceType = $modifyExperienceTypeForm->getData();

            $this->em->persist($experienceType);
            $this->em->flush();

            return $this->redirectToRoute('options');
        };
        
        $modifyDocumentTypeForm = $this->createForm(TypeDocumentType::class, $documentTypeId);
        $modifyDocumentTypeForm->handleRequest($request);
        if($modifyDocumentTypeForm->isSubmitted() && $modifyDocumentTypeForm->isValid())
        {
            $documentType = $modifyDocumentTypeForm->getData();

            $this->em->persist($documentType);
            $this->em->flush();

            return $this->redirectToRoute('options');
        };

        return $this->render('options/modify.html.twig', [ 
            'modify_skill_level' => $modifySkillLevelForm->createView(),
            'modify_experience_type' => $modifyExperienceTypeForm->createView(),
            'modify_document_type' => $modifyDocumentTypeForm->createView() 
        ]);
    }

    /**
     * @Route("/options/delete/{id}", name="delete_options")
     */
    public function deleteOptions(?SkillLevel $skillLevelId, ?TypeExperience $typeExperienceId, ?TypeDocument $typeDocumentId): Response 
    {
        if($skillLevelId){
            $this->em->remove($skillLevelId);
        } elseif($typeExperienceId){
            $this->em->remove($typeExperienceId);
        } elseif($typeDocumentId){
            $this->em->remove($typeDocumentId);
        }
        $this->em->flush();
        return $this->redirectToRoute('options');
    }
}
