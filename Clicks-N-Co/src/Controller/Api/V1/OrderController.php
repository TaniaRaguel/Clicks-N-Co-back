<?php

namespace App\Controller\Api\V1;

use App\Entity\Order;
use App\Entity\Orderline;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/orders", name="api_v1_order_", requirements={"id"="\d+"}))
 */
class OrderController extends AbstractController
{
  /**
   * @Route("", name="browse", methods={"GET"})
   */
  public function browse(OrderRepository $orderRepository): Response
  {
    return $this->json($orderRepository->findAll(), 200, [], [
      'groups' => ['order_browse'],
    ]);
  }

  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(Order $order): Response
  {
    $user = $order->getUser();
    $this->denyAccessUnlessGranted('READ', $user);

    return $this->json($order, 200, [], [
      'groups' => ['order_read'],
    ]);
  }

  /**
   * @Route("", name="add", methods={"POST"})
   */
  public function add(EntityManagerInterface $manager, Request $request, Mailer $mailer,  UserRepository $userRepository, ShopRepository $shopRepository, ProductRepository $productRepository): Response
  {
    $order = new Order;

    $jsonArray = json_decode($request->getContent(), true);

    $userId= $jsonArray["user"]["id"];
    $user = $userRepository->find($userId);
   
    
    
    $orderlines = $jsonArray["cart"];
    // dd($orderlines);
    //________________________________
    // Recalcul du prix total pour vérification
    $verifiedTotal = 0;
    $productIdList = [];

    foreach ($orderlines as $orderline) {
      $productId = $orderline["id"];
      $quantity = $orderline["quantity"];
      $price = $orderline["price"];
    

      $lineTotal = $quantity *$price;
      $verifiedTotal = $verifiedTotal + $lineTotal;
      $productIdList[] = $productId;
    }
    //________________________________________

    $product = $productRepository->find($productIdList[0]);
    $shop = $product->getshop();
    

    $order->setTotalPrice($verifiedTotal);


   /*  $form = $this->createForm(OrderType::class, $order, ['csrf_protection' => false],);
    $form->submit($order); */
 
    /* if ($form->isValid()) { */

      $order->setUser($user);
      $order->setShop($shop);
      $order->setStatus(0);
     
      $manager->persist($order);
      $manager->flush();


      $mailer->sendEmailNewOrderTrader($order);
      $mailer->sendEmailNewOrderCustomer($order);


    foreach ($orderlines as $orderline) {
      $productId = $orderline["id"];
      $product = $productRepository->find($productId);
      $quantity = $orderline["quantity"];
      $price = $orderline["price"];
      $lineTotal = $quantity *$price;

      $orderline = new Orderline;
     $orderline->setOrderRef($order);

     $orderline->setQuantity($quantity);
     $orderline->setPrice($lineTotal);
    
     $orderline->setProduct($product);    

     $manager->persist($orderline);
     $manager->flush();
    }
    //_

      return $this->json($shop, 201, [],[
          'groups' => ['shop_add']

        ]
      );
   /*  } */
   
    /* $errorMessages = [];
    foreach ($form->getErrors(true) as $error) {
      $errorMessages[] = [
        'property' => $error->getOrigin()->getName(),
        'message' => $error->getMessage(),
      ]; 
  } */
  /*  return $this->json($errorMessages, 400); */
  } 






  /**
   * 
   * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
   * 
   */
  public function edit(EntityManagerInterface $manager, Order $order, Request $request): Response
  {
    $this->denyAccessUnlessGranted('EDIT', $order);

    $form = $this->createForm(OrderType::class, $order, ['csrf_protection' => false]);

    $jsonArray = json_decode($request->getContent(), true);


    $form->submit($jsonArray);

    if ($form->isValid()) {
      $manager->persist($order);
      $manager->flush();

      return $this->json($order, 201, [], [
        'groups' => ['order_read'],
      ]);
    }

    $errorMessages = [];
    foreach ($form->getErrors(true) as $error) {
      $errorMessages[] = [
        'property' => $error->getOrigin()->getName(),
        'message' => $error->getMessage(),
      ];
    }
    return $this->json($errorMessages, 400);
  }

  /**
   * @Route("/{id}", name="delete", methods={"DELETE"})
   */
  public function delete(EntityManagerInterface $manager, Order $order, Request $request)
  {
    /* $this->denyAccessUnlessGranted('DELETE', $order); */
    $manager->remove($order);
    $manager->flush();

    return $this->json(null, 204);
  }
}
