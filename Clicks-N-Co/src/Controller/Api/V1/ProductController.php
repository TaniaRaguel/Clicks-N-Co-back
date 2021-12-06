<?php

namespace App\Controller\Api\V1;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/product", name="api_v1_product_", requirements={"id"="\d+"})
 */
class ProductController extends AbstractController
{
  private $manager;

  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  /**
   * @Route("", name="browse", methods={"GET"})
   */
  public function browse(ProductRepository $productRepository): Response
  {
    return $this->json($productRepository->findAll(), 200, [], [
      'groups' => ['product_browse']
    ]);
  }

  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(Product $product): Response
  {
    return $this->json($product, 200, [], [
      'groups' => ['product_read']
    ]);
  }

  /**
   * @Route("", name="add", methods={"POST"})
   */
  public function add(Request $request)
  {
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product, ['csrf_protection' => false]);
    $jsonArray = json_decode($request->getContent(), true);

    $form->submit($jsonArray);

    if ($form->isValid()) {
      $this->manager->persist($product);
      $this->manager->flush();

      return $this->json($product, 201, [], [
        'groups' => ['product_read'],
      ]);
    }
    $errorMessages = [];
    foreach ($form->getErrors(true) as $error) {
      $errorMessages[] = [
        'message' => $error->getMessage(),
        'property' => $error->getOrigin()->getName(),
      ];
    }
    return $this->json($errorMessages, 400);
  }

  /**
   * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
   */
  public function edit(Request $request, Product $product)
  {

    // à gérer avec le voter ? Faire pareill pour add et delete
    // $this->denyAccessUnlessGranted('EDIT', $product);
    $form = $this->createForm(ProductType::class, $product, ['csrf_protection' => false]);
    $jsonArray = json_decode($request->getContent(), true);
   
    $form->submit($jsonArray);
   
    if ($form->isValid()) {
      $this->manager->flush();

      return $this->json($product, 200, [], [
        'groups' => ['product_read'],
      ]);
    }

    $errorMessages = [];
    foreach ($form->getErrors(true) as $error) {
      $errorMessages[] = [
        'message' => $error->getMessage(),
        'property' => $error->getOrigin()->getName(),
      ];
    }

    return $this->json($errorMessages, 400);
  }

  /**
   * @Route("/{id}", name="delete", methods={"DELETE"})
   */
  public function delete(Product $product)
  {
    $this->manager->remove($product);
    $this->manager->flush();

    return $this->json(null, 204);
  }
}
