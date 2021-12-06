<?php

namespace App\Controller\Api\V1;

use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @route("/api/v1/shop",  name="api_v1_shop") 
 */
class shopController extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @Route("/home_shop", name="home_shop")
     */
    public function homeShop(ShopRepository $shopRepository): Response
    {

        return $this->json($shopRepository->FindHomeShop(),200, [], [
            'groups'=> ['shop_homeShop']

        ]);



        
    }
}
