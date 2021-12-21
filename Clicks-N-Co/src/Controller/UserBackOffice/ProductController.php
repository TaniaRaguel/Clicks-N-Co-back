<?php

namespace App\Controller\UserBackOffice;

use App\Entity\Product;
use App\Entity\Shop;
use App\Form\ProductType;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/backoffice/product", name="user_backoffice_product_", requirements={"id"="\d+"})
 */
class ProductController extends AbstractController
{

  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(Product $product)
  {

    $shop = $product->getShop();

    $user = $shop->getUser();
    $this->denyAccessUnlessGranted('READ', $user);

    return $this->render('user_back_office/product/read.html.twig', [
      'product' => $product,
      'user' => $user,
    ]);
  }

  /**
   * @Route("/edit/{id}", name="edit")
   */
  public function edit(Request $request, Product $product, EntityManagerInterface $manager, ImageUploader $imageUploader): Response
  {

    $shop = $product->getShop();
    $user = $shop->getUser();
    $this->denyAccessUnlessGranted('EDIT', $user);
    // On précise qu'on associe $season à notre formulaire
    $form = $this->createForm(ProductType::class, $product);

    $form->handleRequest($request);



    if ($form->isSubmitted() && $form->isValid()) {

      $picture = ($request->files->all()['product']['picture']);
      if ($picture) {
        $imageUploader->uploadProductImage($form);
      }
      
      $product->setUpdatedAt(new \DateTimeImmutable());

      $manager->persist($product);
      $manager->flush();

      return $this->redirectToRoute('user_backoffice_shop_read', [
        'name_slug' => $shop->getNameSlug(),

      ]);
    }

    return $this->render('user_back_office/product/edit.html.twig', [
      'form' => $form->createView(),
      'user' => $user,
      'product' => $product,
      'shop' => $shop,

    ]);
  }

  /**
   * @Route("/{id}/add", name="add")
   */

  public function add(Request $request, EntityManagerInterface $manager, Shop $shop, ImageUploader $imageUploader): Response

  {


    $product = new Product();
    $user = $shop->getUser();
    $this->denyAccessUnlessGranted('ADD', $user);

    $product->getShop();


    $form = $this->createForm(ProductType::class, $product);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $imageUploader->uploadProductImage($form);

      $product->setShop(($shop));
      $manager->persist($product);
      $manager->flush();

      return $this->redirectToRoute('user_backoffice_shop_read', [
        'name_slug' => $shop->getNameSlug(),

      ]);
    }

    return $this->render('user_back_office/product/add.html.twig', [
      'form' => $form->createView(),
      'user' => $user,
      'shop' => $shop,
    ]);
  }

  /**
   * @Route("/delete/{id}", name="delete")
   */
  public function delete(EntityManagerInterface $manager, Product $product)
  {

    $shop = $product->getShop();
    $user = $shop->getUser();
    $this->denyAccessUnlessGranted('DELETE', $user);


    $manager->remove($product);
    $manager->flush();


    return $this->redirectToRoute('user_backoffice_shop_read', [
      'name_slug' => $shop->getNameSlug(),
    ]);
  }
}
