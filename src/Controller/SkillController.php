<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/skill", name="skill")
     */
    public function index(): Response
    {
        $skills = $this->em->getRepository(Skill::class)->findAll();

        return $this->render('skill/index.html.twig', [
            'skills' => $skills,
        ]);
    }

    /**
     * @Route("skill/add", name="add_skill")
     */
    public function addSkill(Request $request)
    {
        $skill = new Skill;
        $addSkillForm = $this->createForm(SkillType::class, $skill);

        $addSkillForm->handlerequest($request);

        if($addSkillForm->isSubmitted() && $addSkillForm->isValid())
        {
            $skill = $addSkillForm->getData();

            $this->em->persist($skill);
            $this->em->flush();
            
            return $this->redirectToRoute('skill');
        }

        return $this->render('skill/add.html.twig', [
            'add_skill_form' => $addSkillForm->createView()
        ]);
    }

    /**
     * @Route("skill/modify/{id}", name="modify_skill")
     */
    public function modifySkill(Skill $id, Request $request)
    {
        $modifySkillForm = $this->createForm(SkillType::class, $id);

        $modifySkillForm->handleRequest($request);

        if($modifySkillForm->isSubmitted() && $modifySkillForm->isValid())
        {
            $id = $modifySkillForm->getData();

            $this->em->persist($id);
            $this->em->flush();

            $role = $this->getUser()->getRoles()[0];

            if($role === 'ROLE_COLLABORATEUR')
            {
                return $this->redirectToRoute('profile');
            }
            else
            {
                return $this->redirectToRoute('skill');
            }
        };

        return $this->render('skill/modify.html.twig', [
            'modify_skill_form' => $modifySkillForm->createView()
        ]);
    }

    /**
     * @Route("skill/delete/{id}", name="delete_skill")
     */
    public function deleteSkill(Skill $id)
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('skill');
    }
}
