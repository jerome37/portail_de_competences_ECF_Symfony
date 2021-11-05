<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Document;
use App\Form\DocumentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/document", name="document")
     */
    public function index(): Response
    {
        $documents = $this->em->getRepository(Document::class)->findAll();
        
        return $this->render('document/index.html.twig', [
            'documents' => $documents,
        ]);
    }

    /**
     * @Route("/document/add", name="add_document")
     */
    public function addDocument(Request $request, SluggerInterface $slugger): Response 
    {
        $document = new Document;
        $addDocumentForm = $this->createForm(DocumentType::class, $document);

        $addDocumentForm->handleRequest($request);

        if($addDocumentForm->isSubmitted() && $addDocumentForm->isValid())
        {
            $document = $addDocumentForm->getData();
            $file = $addDocumentForm->get('file')->getData();

            if($file)
            {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('files_directory'),
                    $newFilename
                );

                $document->setFile($newFilename);
            }

            $id = $request->query->get('id');
            $profile = $this->em->getRepository(Profile::class)->findBy(['id' => $id]);
            $document->setProfile($profile[0]);

            $date= new \DateTime('now');
            $document->setDate($date);

            $this->em->persist($document);
            $this->em->flush();

            return $this->redirectToRoute('document');
        }

        return $this->render("document/add.html.twig", 
            [ 'add_document_form' => $addDocumentForm->createView() ]
        );
    }

    /**
     * @Route("/document/modify/{id}", name="modify_document")
     */
    public function modifyDocument(Document $id, Request $request): Response 
    {
        $modifyDocumentForm = $this->createForm(DocumentType::class, $id);

        $modifyDocumentForm->handleRequest($request);

        if($modifyDocumentForm->isSubmitted() && $modifyDocumentForm->isValid())
        {
            $document = $modifyDocumentForm->getData();

            $this->em->persist($document);
            $this->em->flush();

            return $this->redirectToRoute('document');
        }

        return $this->render("document/modify.html.twig", 
            [ 'modify_document_form' => $addDocumentForm->createView() ]
        );
    }

    /**
     * @Route("/document/delete/{id}", name="delete_document")
     */
    public function deleteDocument(Document $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('document');
    }
}
