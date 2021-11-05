<?php

namespace App\Controller;

use App\Entity\SkillLevel;
use App\Form\SkillLevelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillLevelController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/skill/level", name="skill_level")
     */
    public function index(): Response
    {
        $skillLevels = $this->em->getRepository(SkillLevel::class)->findAll();
        
        return $this->render('skill_level/index.html.twig', [
            'skillLevels' => $skillLevels,
        ]);
    }

    /**
     * @Route("skill/level/add", name="add_skill_level")
     */
    public function addSkillLevel(Request $request)
    {
        $skillLevel = new SkillLevel;
        $addSkillLevelForm = $this->createForm(SkillLevelType::class, $skillLevel);

        $addSkillLevelForm->handlerequest($request);

        if($addSkillLevelForm->isSubmitted() && $addSkillLevelForm->isValid())
        {
            $skillLevel = $addSkillLevelForm->getData();

            $this->em->persist($skillLevel);
            $this->em->flush();
            
            return $this->redirectToRoute('skill_level');
        }

        return $this->render('skill_level/add.html.twig', [
            'add_skill_level_form' => $addSkillLevelForm->createView()
        ]);
    }

    /**
     * @Route("skill/level//modify/{id}", name="modify_skill_level")
     */
    public function modifySkill(SkillLevel $id, Request $request)
    {
        $modifySkillLevelForm = $this->createForm(SkillLevelType::class, $id);

        $modifySkillLevelForm->handleRequest($request);

        if($modifySkillLevelForm->isSubmitted() && $modifySkillLevelForm->isValid())
        {
            $id = $modifySkillLevelForm->getData();

            $this->em->persist($id);
            $this->em->flush();

            return $this->redirectToRoute('skill_level');
        };

        return $this->render('skill_level/modify.html.twig', [
            'modify_skill_level_form' => $modifySkillLevelForm->createView()
        ]);
    }

    /**
     * @Route("skill/level/delete/{id}", name="delete_skill_level")
     */
    public function deleteSkillLevel(SkillLevel $id)
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('skill_level');
    }
}
