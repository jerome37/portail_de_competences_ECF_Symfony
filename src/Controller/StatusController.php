<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatusController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/status", name="status")
     */
    public function index(): Response
    {
        $status = $this->em->getRepository(Status::class)->findAll();
        
        return $this->render('status/index.html.twig', [ 
            'status' => $status 
        ]);
    }

    /**
     * @Route("status/add", name="add_status")
     */
    public function addStatus(Request $request)
    {
        $status = new Status;
        $addStatusForm = $this->createForm(StatusType::class, $status);

        $addStatusForm->handleRequest($request);

        if($addStatusForm->isSubmitted() && $addStatusForm->isValid())
        {
            $status = $addStatusForm->getData();

            $this->em->persist($status);
            $this->em->flush();

            return $this->redirectToRoute('status');
        }

        return $this->render('status/add.html.twig', [ 
            'add_status_form' => $addStatusForm->createView() 
        ]);
    }

    /**
     * @Route("status/modify/{id}", name="modify_status")
     */
    public function modifyProfession(Status $id, Request $request)
    {
        $modifyStatusForm = $this->createForm(StatusType::class, $id);

        $modifyStatusForm->handleRequest($request);

        if($modifyStatusForm->isSubmitted() && $modifyStatusForm->isValid())
        {
            $status = $modifyStatusForm->getData();

            $this->em->persist($status);
            $this->em->flush();

            return $this->redirectToRoute('status');
        }

        return $this->render('status/modify.html.twig', [ 
            'modify_status_form' => $modifyStatusForm->createView() 
        ]);
    }

    /**
     * @Route("/status/delete/{id}", name="delete_status")
     */
    public function deleteProfession(Status $id): Response
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('status');
    }
}
