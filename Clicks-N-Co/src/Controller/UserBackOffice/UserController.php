<?php

namespace App\Controller\UserBackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/back/office/user", name="user_back_office_user")
     */
    public function index(): Response
    {
        return $this->render('user_back_office/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
