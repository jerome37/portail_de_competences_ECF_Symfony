<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/company", name="company")
     */
    public function index(): Response
    {
        $companies = $this->em->getRepository(Company::class)->findAll();
        
        return $this->render('company/index.html.twig', [ 
            'companies' => $companies 
        ]);
    }

    /**
     * @Route("company/add", name="add_company")
     */
    public function addCompany(Request $request): Response 
    {
        $company = new Company;
        $addCompanyForm = $this->createForm(CompanyType::class, $company);

        $addCompanyForm->handleRequest($request);

        if($addCompanyForm->isSubmitted() && $addCompanyForm->isValid())
        {
            $company = $addCompanyForm->getData();

            $this->em->persist($company);
            $this->em->flush();

            return $this->redirectToRoute('company');
        }

        return $this->render('company/add.html.twig', [ 
            'add_company_form' => $addCompanyForm->createView() 
        ]);
    }

    /**
     * @Route("company/modify/{id}", name="modify_company")
     */
    public function modifyCompany(Company $id, Request $request): Response 
    {
        $modifyCompanyForm = $this->createForm(CompanyType::class, $id);

        $modifyCompanyForm->handleRequest($request);

        if($modifyCompanyForm->isSubmitted() && $modifyCompanyForm->isValid())
        {
            $company = $modifyCompanyForm->getData();

            $this->em->persist($company);
            $this->em->flush();

            return $this->redirectToRoute('company');
        }

        return $this->render('company/modify.html.twig', [ 
            'modify_company_form' => $modifyCompanyForm->createView() 
        ]);
    }

    /**
     * @Route("company/delete/{id}", name="delete_company")
     */
    public function deleteCompany(Company $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('company');
    }
}
