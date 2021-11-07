<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findAll();
        
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("category/add", name="add_category")
     */
    public function addCategory(Request $request): Response
    {
        $category = new Category;
        $addCategoryForm = $this->createForm(CategoryType::class, $category);

        $addCategoryForm->handlerequest($request);

        if($addCategoryForm->isSubmitted() && $addCategoryForm->isValid())
        {
            $category = $addCategoryForm->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('category');
        }

        return $this->render('category/add.html.twig', [ 
            'add_category_form' => $addCategoryForm->createView() 
        ]);
    }

    /**
     * @Route("category/modify/{id}", name="modify_category")
     */
    public function modifyCategory(Category $id, Request $request): Response 
    {
        $modifyCategoryForm = $this->createForm(CategoryType::class, $id);

        $modifyCategoryForm->handleRequest($request);

        if($modifyCategoryForm->isSubmitted() && $modifyCategoryForm->isValid())
        {
            $category = $modifyCategoryForm->getData();

            $this->em->flush($id);

            return $this->redirectToRoute('category');
        }

        return $this->render('category/modify.html.twig', [ 
            'modify_category_form' => $modifyCategoryForm->createView()
        ]);
    }

    /**
     * @Route("category/delete/{id}", name="delete_category")
     */
    public function deleteCategory(Category $id): Response 
    {
        $this->em->remove($id);
        $this->em->flush();

        return $this->redirectToRoute('category');
    }
}
