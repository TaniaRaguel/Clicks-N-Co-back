<?php

namespace App\Controller\Api\V1;

use App\Entity\Shop;
use App\Entity\User;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @route("/api/v1/shops",  name="api_v1_shop_", requirements={"id"="\d+"}) 
 */
class ShopController extends AbstractController
{

  private $manager;

  public function __construct(EntityManagerInterface $manager)
  {
    $this->manager = $manager;
  }


  /**
   * @Route("/home", name="home_shop", methods={"GET"})
   */
  public function homeShop(ShopRepository $shopRepository): Response
  {
    // dd($shopRepository->FindHomeShop());
    return $this->json($shopRepository->FindHomeShop(), 200, [], [
      'groups' => ['shop_homeShop']

    ]);
  }


  /**
   * 
   *show all shop
   *
   * @route("", name="browse", methods={"GET"})
   * 
   * @param Shop $shop
   * 
   * @return void
   */
  public function browse(ShopRepository $shopRepository)
  {
    return $this->json(
      $shopRepository->findAll(),
      200,
      [],
      [
        'groups' => ['shop_browse']

      ]
    );
  }



  /**
   * 
   *show one shop
   *
   * @route("/{id}", name="read", methods={"GET"})
   * 
   * @param Shop $shop
   * 
   * @return void
   */
  public function read(Shop $shop)
  {
    return $this->json(
      $shop,
      200,
      [],
      ['groups' => ['shop_read']]
    );
  }



  /**
   * 
   *add one shop
   *
   * @route("/{id}/add", name="add", methods={"POST"})
   * 
   * @param Shop $shop
   * 
   * @return void
   */
  public function add(Request $request, Slugger $slugger, User $user)
  {
    $shop = new Shop;
    $form = $this->createForm(ShopType::class, $shop, ['csrf_protection' => false]);

    $jsonArray = json_decode($request->getContent(), true);

    $form->submit($jsonArray);

    if ($form->isValid()) {

      $shop->setUser($user);
      $user->setRoles(['ROLE_TRADER']);

      $slugger->slugifyShopName($shop);
      $slugger->slugifyShopCity($shop);


      $this->manager->persist($shop);
      $this->manager->flush();

      return $this->json(
        $shop,
        201,
        [],
        [
          'groups' => ['shop_add']

        ]
      );
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
   * 
   *Edit one shop
   *
   * @route("/{id}", name="edit", methods={"PUT", "PATCH"})
   * 
   * @param Shop $shop
   * 
   * @return void
   */
  public function edit(Request $request, Shop $shop)
  {

    $form = $this->createForm(ShopType::class, $shop, ['csrf_protection' => false]);
    $jsonArray = json_decode($request->getContent(), true);

    $form->submit($jsonArray);

    if ($form->isValid()) {
      $this->manager->flush();

      return $this->json($shop, 200, [], [
        'groups' => ['shop_edit'],
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
  public function delete(Shop $shop)
  {
    $this->manager->remove($shop);
    $this->manager->flush();

    return $this->json(null, 204);
  }

  /**
   * search every shop matching the search city
   * 
   * @route("/searchbycity", name="search", methods={"POST"})
   *
   * @param Request $request
   * @param ShopRepository $shopRepository
   * @return Response
   */
  public function resultsByCity(Request $request, ShopRepository $shopRepository): Response
  {

    /*  $searchCity = $request->get('search'); */
    $jsonArray = json_decode($request->getContent(), true);
    $searchCity = trim($jsonArray["searchValue"]);


    // 3) On transmet le résultat à la vue HTML
    return $this->json($shopRepository->findAllBySearchTermDQL($searchCity), 200, [], [
      'groups' => ['shop_search'],

    ]);
  }
}
