<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use App\Entity\Profession;
use App\Entity\SkillLevel;
use App\Entity\TypeDocument;
use App\Form\ProfessionType;
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
        $professions = $this->em->getRepository(Profession::class)->findAll();

        $statii = $this->em->getRepository(Status::class)->findAll();

        $skillLevels = $this->em->getRepository(SkillLevel::class)->findAll();

        $experienceTypes = $this->em->getRepository(TypeExperience::class)->findAll();

        $documentTypes = $this->em->getRepository(TypeDocument::class)->findAll();

        return $this->render('options/index.html.twig', [
            'professions' => $professions,
            'statii' => $statii,
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
        $profession = new Profession;
        $addProfessionForm = $this->createForm(ProfessionType::class, $profession);
        $addProfessionForm->handleRequest($request);
        if($addProfessionForm->isSubmitted() && $addProfessionForm->isValid())
        {
            $profession = $addProfessionForm->getData();

            $this->em->persist($profession);
            $this->em->flush();

            return $this->redirectToRoute('options');
        }
        
        $status = new Status;
        $addStatusForm = $this->createForm(StatusType::class, $status);
        $addStatusForm->handleRequest($request);
        if($addStatusForm->isSubmitted() && $addStatusForm->isValid())
        {
            $status = $addStatusForm->getData();

            $this->em->persist($status);
            $this->em->flush();

            return $this->redirectToRoute('options');
        }
        
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
            'add_profession_form' => $addProfessionForm->createView(),
            'add_status_form' => $addStatusForm->createView(),
            'add_skill_level_form' => $addSkillLevelForm->createView(),
            'add_experience_form' => $addExperienceTypeForm->createView(),
            'add_document_form' => $addDocumentTypeForm->createView()
        ]);
    }

    /**
     * @Route("/options/modify/{id}", name="modify_options")
     */
    public function modifyOptions(?Profession $professions, ?Status $status, ?SkillLevel $skillLevelId, ?TypeExperience $typeExperienceId, ?TypeDocument $documentTypeId, Request $request): Response 
    {
        $modifyProfessionForm = $this->createForm(ProfessionType::class, $professions);
        $modifyProfessionForm->handleRequest($request);
        if($modifyProfessionForm->isSubmitted() && $modifyProfessionForm->isValid())
        {
            $profession = $modifyProfessionForm->getData();

            $this->em->persist($profession);
            $this->em->flush();

            return $this->redirectToRoute('options');
        }

        $modifyStatusForm = $this->createForm(StatusType::class, $status);
        $modifyStatusForm->handleRequest($request);
        if($modifyStatusForm->isSubmitted() && $modifyStatusForm->isValid())
        {
            $status = $modifyStatusForm->getData();

            $this->em->persist($status);
            $this->em->flush();

            return $this->redirectToRoute('options');
        }
        
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
            'modify_profession_form' => $modifyProfessionForm->createView(),
            'modify_status_form' => $modifyStatusForm->createView(),
            'modify_skill_level_form' => $modifySkillLevelForm->createView(),
            'modify_experience_form' => $modifyExperienceTypeForm->createView(),
            'modify_document_form' => $modifyDocumentTypeForm->createView() 
        ]);
    }

    /**
     * @Route("/options/delete/{id}", name="delete_options")
     */
    public function deleteOptions(?Profession $profession, ?Status $status,?SkillLevel $skillLevelId, ?TypeExperience $typeExperienceId, ?TypeDocument $typeDocumentId): Response 
    {
        if($profession){
            $this->em->remove($profession);
        } elseif($status){
            $this->em->remove($status);
        } elseif($skillLevelId){
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
