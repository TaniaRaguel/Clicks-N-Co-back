<?php

namespace App\Controller\UserBackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("user/back/office/product", name="user_back_office_product")
     */
    public function index(): Response
    {
        return $this->render('user_back_office/product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
