<?php

namespace App\Controller\UserBackOffice;

use App\Entity\Order;
use App\Entity\Shop;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
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
    $this->denyAccessUnlessGranted('READ', $user);


    $ordersToPrepare = [];
        $ordersPreparing = [];
        $ordersPrepared = [];
        $ordersArchived = [];
        foreach($orders as $order) {
            if($order->getStatus() == 0) {
                $ordersToPrepare[] = $order;
            }
            if($order->getStatus() == 1) {
                $ordersPreparing[] = $order;
            }
            if($order->getStatus() == 2) {
                $ordersPrepared[] = $order;
            }
            if($order->getStatus() == 3) {
                $ordersArchived[] = $order;
            }
        }

    return $this->render('user_back_office/order/read.html.twig', [
      'orders' => $orders,
      'user' => $user,
      'shop' => $shop,
      'ordersPreparing' => $ordersPreparing,
      'ordersToPrepare' => $ordersToPrepare,
      'ordersPrepared' => $ordersPrepared,
      'ordersArchived' => $ordersArchived,

          

           
    ]);
  }


  /**
   * @Route("/updateStatus/{id}", name="updateStatus")
   */
  public function prepareOrder(EntityManagerInterface $manager, Order $order, Mailer $mailer)
  {
    $shop = $order->getShop();
    $shopId = $shop->getId();
    $orders = $shop->getOrders();

    $user = $shop->getUser();

    if ($order->getStatus() == 0) {
      $order->setStatus(1);
      $order->setUpdatedAt(new \DateTimeImmutable());
      $manager->flush();
    } elseif ($order->getStatus() == 1) {
      $order->setStatus(2);
      $order->setUpdatedAt(new \DateTimeImmutable());
      // $mailer->sendReadyOrder($order);
      $manager->flush();
    } elseif ($order->getStatus() == 2) {
      $order->setStatus(3);
      $order->setUpdatedAt(new \DateTimeImmutable());
      $manager->flush();
    }

    return $this->redirectToRoute('user_backoffice_order_read', [
      'id' => $shopId,
      'orders' => $orders,
      'user' => $user,
      'shop' => $shop,
    ]);
  }

  /**
   * @Route("/delete/{id}", name="delete")
   */
  public function delete(EntityManagerInterface $manager, Order $order)
  {
    $shop = $order->getShop();
    $shopId = $shop->getId();
    $orders = $shop->getOrders();
    $user = $shop->getUser();

    $order->setStatus(4);
    $manager->flush();

    return $this->redirectToRoute('user_backoffice_order_read', [
      'id' => $shopId,
      'orders' => $orders,
      'user' => $user,
      'shop' => $shop,
    ]);
  }
}
