<?php

namespace App\Controller\Api\V1;

use App\Entity\Orderline;
use App\Form\OrderlineType;
use App\Repository\OrderlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/orderlines", name="api_v1_orderline_", requirements={"id"="\d+"})
 */
class OrderlineController extends AbstractController
{

  private $manager;

  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }

  /**
   * @Route("", name="browse", methods={"GET"})
   */
  public function browse(OrderlineRepository $orderlineRepository): Response
  {
    return $this->json($orderlineRepository->findAll(), 200, [], [
      'groups' => ['orderline_browse']
    ]);
  }

  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(Orderline $orderline): Response
  {
    return $this->json($orderline, 200, [], [
      'groups' => ['orderline_read']
    ]);
  }

  /**
   * @Route("", name="add", methods={"POST"})
   */
  public function add(Request $request)
  {
    $orderline = new Orderline();
    $form = $this->createForm(OrderlineType::class, $orderline, ['csrf_protection' => false]);
    $jsonArray = json_decode($request->getContent(), true);

    $form->submit($jsonArray);

    if ($form->isValid()) {
      $this->manager->persist($orderline);
      $this->manager->flush();

      return $this->json($orderline, 201, [], [
        'groups' => ['orderline_read'],
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
  public function edit(Request $request, Orderline $orderline)
  {

    // à gérer avec le voter ? Faire pareill pour add et delete
    // $this->denyAccessUnlessGranted('EDIT', $orderline);
    $form = $this->createForm(orderlineType::class, $orderline, ['csrf_protection' => false]);
    $jsonArray = json_decode($request->getContent(), true);

    $form->submit($jsonArray);

    if ($form->isValid()) {
      $this->manager->flush();

      return $this->json($orderline, 200, [], [
        'groups' => ['orderline_read'],
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
  public function delete(Orderline $orderline)
  {
    $this->manager->remove($orderline);
    $this->manager->flush();

    return $this->json(null, 204);
  }
}
