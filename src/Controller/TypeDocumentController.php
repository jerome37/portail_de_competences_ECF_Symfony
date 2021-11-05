<?php

namespace App\Controller;

use App\Entity\TypeDocument;
use App\Form\TypeDocumentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeDocumentController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/type/document", name="type_document")
     */
    public function index(): Response
    {
        $documentTypes = $this->em->getRepository(TypeDocument::class)->findAll();
        
        return $this->render('type_document/index.html.twig', [
            'document_types' => $documentTypes,
        ]);
    }

    /**
     * @Route("/type/document/add", name="add_type_document")
     */
    public function addTypeDocument(Request $request): Response 
    {
        $documentType = new TypeDocument;
        $addDocumentTypeForm = $this->createForm(TypeDocumentType::class, $documentType);

        $addDocumentTypeForm->handleRequest($request);

        if($addDocumentTypeForm->isSubmitted() && $addDocumentTypeForm->isValid())
        {
            $documentType = $addDocumentTypeForm->getData();

            $this->em->persist($documentType);
            $this->em->flush();

            return $this->redirectToRoute('type_document');
        }

        return $this->render('type_document/add.html.twig', 
            [ 'add_document_type_form' => $addDocumentTypeForm->createView() ]
        );
    }

    /**
     * @Route("/type/document/modify/{id}", name="modify_type_document")
     */
    public function modifyTypeDocument(TypeDocument $id, Request $request): Response 
    {
        $modifyDocumentTypeForm = $this->createForm(TypeDocumentType::class, $id);

        $modifyDocumentTypeForm->handleRequest($request);

        if($modifyDocumentTypeForm->isSubmitted() && $modifyDocumentTypeForm->isValid())
        {
            $documentType = $modifyDocumentTypeForm->getData();

            $this->em->persist($documentType);
            $this->em->flush();

            return $this->redirectToRoute('type_document');
        }

        return $this->render('type_document/modify.html.twig', 
            [ 'modify_document_type_form' => $modifyDocumentTypeForm->createView() ]
        );
    }


    /**
     * @Route("/type/document/delete/{id}", name="delete_type_document")
     */
    public function deleteTypeDocument(TypeDocument $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('type_document');
    }
}
