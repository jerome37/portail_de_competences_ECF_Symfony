<?php

namespace App\Controller;

use App\Entity\Profession;
use App\Form\ProfessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfessionController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/profession", name="profession")
     */
    public function index(): Response
    {
        $professions = $this->em->getRepository(Profession::class)->findAll();
        
        return $this->render('profession/index.html.twig', [ 
            'professions' => $professions 
        ]);
    }

    /**
     * @Route("profession/add", name="add_profession")
     */
    public function addProfession(Request $request)
    {
        $profession = new Profession;
        $addProfessionForm = $this->createForm(ProfessionType::class, $profession);

        $addProfessionForm->handleRequest($request);

        if($addProfessionForm->isSubmitted() && $addProfessionForm->isValid())
        {
            $profession = $addProfessionForm->getData();

            $this->em->persist($profession);
            $this->em->flush();

            return $this->redirectToRoute('profession');
        }

        return $this->render('profession/add.html.twig', [
            'add_profession_form' => $addProfessionForm->createView(),
        ]);
    }

    /**
     * @Route("profession/modify/{id}", name="modify_profession")
     */
    public function modifyProfession(Profession $id, Request $request)
    {
        $modifyProfessionForm = $this->createForm(ProfessionType::class, $id);

        $modifyProfessionForm->handleRequest($request);

        if($modifyProfessionForm->isSubmitted() && $modifyProfessionForm->isValid())
        {
            $profession = $modifyProfessionForm->getData();

            $this->em->persist($profession);
            $this->em->flush();

            return $this->redirectToRoute('profession');
        }

        return $this->render('profession/modify.html.twig', [
            'modify_profession_form' => $modifyProfessionForm->createView(),
        ]);
    }

    /**
     * @Route("/profession/delete/{id}", name="delete_profession")
     */
    public function deleteProfession(Profession $id): Response
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('profession');
    }
}
