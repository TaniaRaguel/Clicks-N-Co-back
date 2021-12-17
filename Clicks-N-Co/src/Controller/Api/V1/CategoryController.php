<?php

namespace App\Controller\Api\V1;

use App\Entity\Category;
use App\Entity\Shop;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/categories", name="api_v1_category_")
 * 
 */
class CategoryController extends AbstractController
{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

      /**
     * show 3 categories on the homepage
     * @Route("/home", name="home",  methods={"GET"})
     */
    public function homeCategory(CategoryRepository $categoryRepository): Response
    {
        return $this->json($categoryRepository->findHomeCategory(), 200, [], [
            'groups' => ['category_home']
        ]);
    }


    /**
     * show every category
     * @Route("", name="",  methods={"GET"})
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        return $this->json($categoryRepository->FindHomeCategory(),200, [], [
            'groups'=> ['category_browse']

        ]);

    }
    /**
     * show one category
     *
     *  @Route("/{id}", name="read",  methods={"GET"})
     * 
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function read(Category $category): Response
    {
        return $this->json($category, 200, [], [
            'groups' => ['category_read']
        ]);

    }
    
     /**
     * Edit one category
     *
     *  @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     * 
     * 
     * @return Response
     */
    public function edit(Request $request, Category $category): Response
    {
        
        $form =$this->createForm(CategoryType::class, $category, ['csrf_protection' => false]);

        $jsonArray = json_decode($request->getContent(), true);

       $form->submit($jsonArray);

        if($form->isValid()) {
            
            $this->manager->flush();
            
            return $this->json($category, 200, [], [
                'groups' => ['category_edit']
            ]);
        }

        $errorMessages = [];
        foreach($form->getErrors(true) as $error) {
            $errorMessages[] = [
                'message' => $error->getMessage(),
                'property' => $error->getOrigin()->getName(),
            ];
        }

       
        return $this->json($errorMessages, 400);

    }

        /**
     * Edit one category
     *
     *  @Route("", name="add", methods={"POST"})
     * 
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        
        $form =$this->createForm(CategoryType::class, $category, ['csrf_protection' => false]);

        $jsonArray = json_decode($request->getContent(), true);

       $form->submit($jsonArray);

        if($form->isValid()) {
            
            $this->manager->persist($category);
            $this->manager->flush();
            
            return $this->json($category, 201, [], [
                'groups' => ['category_add']
            ]);
        }

        $errorMessages = [];
        foreach($form->getErrors(true) as $error) {
            $errorMessages[] = [
                'message' => $error->getMessage(),
                'property' => $error->getOrigin()->getName(),
            ];
        }

       
        return $this->json($errorMessages, 400);

    }

     /**
      * 
      * Delete one category
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Shop $shop)
    {
        $this->manager->remove($shop);
        $this->manager->flush();

        return $this->json(null, 204);
    }

    

}
