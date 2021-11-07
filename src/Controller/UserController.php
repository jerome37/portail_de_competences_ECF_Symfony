<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Status;
use App\Form\UserType;
use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        $users = $this->em->getRepository(User::class)->findAll();
        
        return $this->render('user/index.html.twig', [ 
            'users' => $users 
        ]);
    }

    /**
     * @Route("/user/add", name="add_user")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User;
        $addUserForm = $this->createForm(UserType::class, $user);

        $addUserForm->handleRequest($request);

        if($addUserForm->isSubmitted() && $addUserForm->isValid())
        {
            $user = $addUserForm->getData();

            $password = $user->getPassword();
            $passwordEncoded = $encoder->encodePassword($user, $password);
            $user->setPassword($passwordEncoded);

            $date= new \DateTime('now');
            $user->setDate($date);

            // Récupération de l'id du profil de la personne à convertir en collaborateur-trice...
            $id = $request->query->get('id');
            //... pour en récupérer les informations...
            $profile = $this->em->getRepository(Profile::class)->findBy(['id' => $id]);

            // ... récupération du statut 'collaborateur'...
            $collabStatus = $this->em->getRepository(Status::class)->findBy(['name' => 'collaborateur']);
            // ... pour les renseigner en tant que nouveau statut, avec la date de modification (pour le commercial) ... 
            
            if($profile)
            {
                $profile[0]->setStatus($collabStatus[0])
                       ->setDateModification($date);

                // ... le profil ainsi actualisé est transmis à l'objet 'User' pour finaliser l'hydratation
                $user->setProfile($profile[0]);
            }

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('user');
        }
        
        return $this->render('user/add.html.twig', [
            'add_user_form' => $addUserForm->createView(),
        ]);
    }

    /**
     * @Route("/user/modify/{id}", name="modify_user")
     */
    public function modifyUser(User $id, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $updateUserForm = $this->createForm(UserType::class, $id);

        $updateUserForm->handlerequest($request);

        if($updateUserForm->isSubmitted())
        {
            $user = $updateUserForm->getData();

            $password = $user->getPassword();
            $passwordEncoded = $encoder->encodePassword($user, $password);
            $user->setPassword($passwordEncoded);

            $date= new \DateTime('now');
            $user->setDate($date);
           
            $this->em->flush($id);

            return $this->redirectToRoute('user');
        }

        return $this->render('user/modify.html.twig', [
            'modify_user_form' => $updateUserForm->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="delete_user")
     */
    public function deleteUser(User $id, Request $request): Response
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('user');
    }
}
