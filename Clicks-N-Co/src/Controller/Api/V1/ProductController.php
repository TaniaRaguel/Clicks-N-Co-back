<?php

namespace App\Controller\Api\V1;

use App\Entity\Product;
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
}
