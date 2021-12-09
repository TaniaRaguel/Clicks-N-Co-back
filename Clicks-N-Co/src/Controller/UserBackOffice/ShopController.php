<?php

namespace App\Controller\UserBackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("user/back/office/shop", name="user_back_office_shop")
     */
    public function index(): Response
    {
        return $this->render('user_back_office/shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }
}
