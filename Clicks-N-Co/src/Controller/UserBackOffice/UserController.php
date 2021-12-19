<?php

namespace App\Controller\UserBackOffice;

use App\Entity\Shop;
use App\Service\Slugger;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



/**
     * @Route("/user/backoffice/user", name="user_backoffice_user_")
     */
class UserController extends AbstractController
{
    
   


        /**
         * Affiche les information du user et son ou ses shops
         * 
         * @Route("/{id}", name="read")
         */
        Public function read (User $user)
        {

            $this->denyAccessUnlessGranted('READ', $user);

            $shops = $user->getshops();
            
            return $this->render('user_back_office/user/index.html.twig', [
            'user' => $user,
            'shops' => $shops
        ]);
        }

        
        
 /**
     * 
     * @Route("/{id}", name="edit")
     * 
     */
    public function edit(EntityManagerInterface $manager, Request $request, Slugger $slugger, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $this->denyAccessUnlessGranted('EDIT', $user);

        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);

        $jsonArray = json_decode($request->getContent(), true);
        

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $password = $jsonArray['password'];
            if ($password != null) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }

            $slugger->slugifyUserCity($user);

            $manager->flush();

            return $this->redirectToRoute('user_backoffice_read');
        }

       

        return $this->render ('user_back_office/user/edit.html.twig', [
            'form' => $form->createView()
          ]);
    }

    


    
}
