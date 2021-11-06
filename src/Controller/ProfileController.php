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
        // A la connexion, récupération de l'id du profil de la personne connectée...
        // $id = $this->getUser()->getId();
        $id = $request->query->get('id');
        // dd($id);
        if($id){
            // $profile = $this->em->getRepository(Profile::class)->findBy(
            //     [ 'id' => $id ]
            // );
            $profile = $this->em->getRepository(Profile::class)->findBy(
                [ 'id' => $id ]
            )[0];
        } else {
            // $id = $this->getUser()->getProfile()->getId();
            // $profile = $this->em->getRepository(Profile::class)->findBy(
            //     [ 'id' => $id ]
            // );
            $profile = $this->getUser()->getProfile();
            // dd($profile);
            if($profile === null){
                return $this->redirectToRoute('dashboard');
            }
        }
        // dd($profile);

        // $id = $this->getUser()->getProfile()->getId();

        // ... et du profile de l'utilisateur ...
        // $user = $this->em->getRepository(User::class)->findBy(
        //     [ 'id' => $id ]
        // );
        $user = $this->getUser();
        // dd($this->getUser());

        // ... pour permettre d'en récupérer les infos complètes que sont :
        // le profile
        // $profile = $this->em->getRepository(Profile::class)->findBy(
        //     [ 'id' => $id ]
        // );
        
        // et les compétences rattachées
        $skills = $this->em->getRepository(ProfileSkill::class)->findBy(
            // [ 'profile' => $profile[0]->getId() ]
            [ 'profile' => $profile->getId() ]
        );

        // En plus, on récupère également le nom de toutes les catégories pour les besoins de la configuration du front
        $categories = $this->em->getRepository(Category::class)->findAll();
        
        // ... On récupère les expériences :
        $experiences = $this->em->getRepository(Experience::class)->findBy(
            // [ 'profile' => $profile[0]->getId() ]
            [ 'profile' => $profile->getId() ]
        );

        // ... ainsi que les documents
        $documentTypes = $this->em->getRepository(TypeDocument::class)->findAll();
        
        $documents = $this->em->getRepository(Document::class)->findBy(
            // [ 'profile' => $profile[0]->getId() ]
            [ 'profile' => $profile->getId() ]
        );

        // $docName = $documents[0]->getFile();
        // $pdf = new File($docName);
        // dd($this->file($pdf));

        // ... afin de les transmettre au front pour l'affichage
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
