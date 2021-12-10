<?php

namespace App\Controller\UserBackOffice;

use App\Entity\Order;
use App\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/backoffice/order", name="user_backoffice_order_", requirements={"id"="\d+"})
 */
class OrderController extends AbstractController
{
  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(Shop $shop)
  {

    $orders = $shop->getOrders();

    $user = $shop->getUser();

    return $this->render('user_back_office/order/read.html.twig', [
      'orders' => $orders,
      'user' => $user,
      'shop' => $shop,
    ]);
  }
}
