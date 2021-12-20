<?php

namespace App\Controller\UserBackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("user/backoffice/about", name="user_backoffice_about")
     */
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            
        ]);
    }
}
