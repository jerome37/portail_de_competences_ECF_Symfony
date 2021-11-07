<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Category;
use App\Entity\Document;
use App\Form\ProfileType;
use App\Entity\Experience;
use App\Entity\ProfileSkill;
use App\Entity\TypeDocument;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/profile", name="profile")
     */
    public function index(?Request $request): Response
    {
        $id = $request->query->get('id');
       
        if($id){
            $profile = $this->em->getRepository(Profile::class)->findOneBy(
                [ 'id' => $id ]
            );
        } else {
            $profile = $this->getUser()->getProfile();

            if($profile === null){
                return $this->redirectToRoute('dashboard');
            }
        }

        $user = $this->getUser();
        
        $skills = $this->em->getRepository(ProfileSkill::class)->findBy([ 
            'profile' => $profile->getId() 
        ]);
    
        $experiences = $this->em->getRepository(Experience::class)->findBy([ 
            'profile' => $profile->getId() 
        ]);
        
        $documents = $this->em->getRepository(Document::class)->findBy([ 
            'profile' => $profile->getId() 
        ]);

        $categories = $this->em->getRepository(Category::class)->findAll();
        $documentTypes = $this->em->getRepository(TypeDocument::class)->findAll();

        return $this->render('profile/index.html.twig', [ 
            'user' => $user,
            'profile' => $profile,
            'skills' => $skills,
            'categories' => $categories,
            'experiences' => $experiences,
            'documentTypes' => $documentTypes,
            'documents' => $documents 
        ]);
    }

    /**
     * @Route("/profile/all", name="all_profiles")
     */
    public function allProfiles(): Response 
    {
        $profiles = $this->em->getRepository(Profile::class)->findAll();
        
        return $this->render('profile/all.html.twig', [
            'profiles' => $profiles,
        ]);
    }

    /**
     * @Route("/profile/candidates/all", name="all_candidates_profiles")
     */
    public function allCandidatesProfiles(): Response 
    {
        $profiles = $this->em->getRepository(Profile::class)->getAllCandidates();
        
        return $this->render('profile/candidates.html.twig', [
            'profiles' => $profiles,
        ]);
    }

    /**
     * @Route("/profile/collaborators/all", name="all_collaborators_profiles")
     */
    public function allCollaboratorsProfiles(): Response 
    {
        $profiles = $this->em->getRepository(Profile::class)->getAllCollaborators();
        
        return $this->render('profile/collaborators.html.twig', [
            'profiles' => $profiles,
        ]);
    }

    /**
     * @Route("profile/add", name="add_profile")
     */
    public function addProfile(Request $request)
    {
        $profile = new Profile;
        $addProfileForm = $this->createForm(ProfileType::class, $profile);

        $addProfileForm->handleRequest($request);

        if($addProfileForm->isSubmitted() && $addProfileForm->isValid())
        {
            $profile = $addProfileForm->getData();
            
            $date = new \DateTime('now');
            $profile->setDate($date);

            $this->em->persist($profile);
            $this->em->flush();

            return $this->redirectToRoute('all_profiles');
        }

        return $this->render('profile/add.html.twig', [
            'add_profile_form' => $addProfileForm->createView(),
        ]);
    }

    /**
     * @Route("/profile/modify/{id}", name="modify_profile")
     */
    public function modifyProfile(Profile $id, Request $request): Response
    {
        $updateProfileForm = $this->createForm(ProfileType::class, $id);

        $originalStatus = $id->getStatus();

        $updateProfileForm->handlerequest($request);

        if($updateProfileForm->isSubmitted() && $updateProfileForm->isValid())
        {
            $profile = $updateProfileForm->getData();
            
            $status = $profile->getStatus();
            if($status)
            {
                $profile->setStatus($status);
            }
            else
            {
                $profile->setStatus($originalStatus);
            }

            $date = new \DateTime('now');
            $profile->setDateModification($date);

            $this->em->persist($id);
            $this->em->flush();
            
            if($profile->getUser())
            {
                if($profile->getUser()->getRoles()[0] === 'ROLE_COLLABORATEUR'){
                    return $this->redirectToRoute('profile');
                }
                else{
                    return $this->redirectToRoute('all_profiles');
                }
            }
            else
            {
                return $this->redirectToRoute('all_profiles');
            }
        
        }

        return $this->render('profile/modify.html.twig', [
            'modify_profile_form' => $updateProfileForm->createView()
        ]);
    }

    /**
     * @Route("/profile/delete/{id}", name="delete_profile")
     */
    public function deleteProfile(Profile $id): Response
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('all_profiles');
    }

}
