<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\ProfileSkill;
use App\Form\ProfileSkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileSkillController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("profile/skill/add/{id}", name="add_skill_to_profile")
     */
    public function addSkilltoProfile(Profile $id, Request $request)
    {
        // dd($id->getId());
        // dd($this->em->getrepository(ProfileSkill::class)->findBy(['profile'=>$id->getId()]));
        $skill = new ProfileSkill;
        $addSkillToProfileForm = $this->createForm(ProfileSkillType::class, $skill);
        // $addSkillToProfileForm = $this->createForm(ProfileSkillType::class, $id);

        $addSkillToProfileForm->handleRequest($request);

        if($addSkillToProfileForm->isSubmitted() && $addSkillToProfileForm->isValid())
        {
            $skill = $addSkillToProfileForm->getData();

            $skill->setProfile($id);

            $this->em->persist($skill);
            $this->em->flush();

            return $this->redirectToRoute('profile', ['id' => $id]);
        }

        return $this->render('profile_skill/add.html.twig', [
            'add_skill_to_profile_form' => $addSkillToProfileForm->createView()
        ]);
    }

    /**
     * @Route("/profile/skill/{id}", name="profile_skill")
     */
    public function index(Profile $id): Response
    {
        $skills = $this->em->getRepository(ProfileSkill::class)->findBy([
            'profile' => $id
        ]);

        $skillsInfos = [];
        
        foreach($skills as $skill)
        {
            $level = $skill->getLevel();
            $appreciation = $skill->getAppreciation();
            $name = $skill->getSkill()->getName();

            array_push($skillsInfos, [$name, $level, $appreciation]);
        }
        dd($id);
        return $this->render('profile_skill/index.html.twig', [
            'skills_infos' => $skillsInfos,
            'id' => $id
        ]);
    }

    /**
     * @Route("/profile/skill/modify/{id}", name="modify_skill_to_profile")
     */
    public function modifySkilltoProfile(ProfileSkill $id, Request $request): Response
    {
        $modifySkillToProfileForm = $this->createForm(ProfileSkillType::class, $id);

        $modifySkillToProfileForm->handlerequest($request);

        if($modifySkillToProfileForm->isSubmitted() && $modifySkillToProfileForm->isValid())
        {
            $skillToProfile = $modifySkillToProfileForm->getData();
           
            $this->em->flush($id);

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile_skill/modify.html.twig', [
            'modify_skill_to_profile' => $modifySkillToProfileForm->createView()
        ]);
    }

    /**
     * @Route("profile/skill/delete/{id}", name="delete_skill_to_profile")
     */
    public function deleteSkillToProfile(ProfileSkill $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('profile');
    }
}
