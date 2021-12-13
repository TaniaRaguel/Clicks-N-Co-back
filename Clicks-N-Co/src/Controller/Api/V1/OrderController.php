<?php

namespace App\Controller\Api\V1;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
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
    $this->denyAccessUnlessGranted('READ', $order);

    return $this->json($order, 200, [], [
      'groups' => ['order_read'],
    ]);
  }

  /**
   * @Route("", name="add", methods={"POST"})
   */
  public function add(EntityManagerInterface $manager, Request $request): Response
  {
    $order = new Order;

    $this->denyAccessUnlessGranted('ADD', $order);

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
    $this->denyAccessUnlessGranted('DELETE', $order);
    $manager->remove($order);
    $manager->flush();

    return $this->json(null, 204);
  }
}
