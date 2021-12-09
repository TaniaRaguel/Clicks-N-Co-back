<?php

namespace App\Controller\UserBackOffice;

use App\Entity\Shop;
use App\Entity\User;
use App\Form\ShopType;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("user/backoffice/shop", name="user_backoffice_shop_")
 */
class ShopController extends AbstractController
{
    /**
     * 
     * Show all user's shops
     * 
     * @Route("/user/{id}", name="browse", requirements={"id"="\d+"})
     */
    public function browse(User $user): Response
    {
        // dd($user);
        return $this->render('user_back_office/shop/index.html.twig', [
            'shops' => $user->getShops(),
        ]);
    }

    /**
     * 
     * Show details of one user's shop
     * 
     * @Route("/{name_slug}", name="read")
     */
    public function read(Shop $shop): Response
    {
        return $this->render('user_back_office/shop/read.html.twig', [
            'shop' => $shop,
        ]);
    }

    /**
     * 
     * Allow user to edit one shop in his backoffice
     *
     * @route("/edit/{name_slug}", name="edit")
     * 
     */
    public function edit(EntityManagerInterface $manager, Request $request, Shop $shop, Slugger $slugger)
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slugger->slugifyShopName($shop);
            $slugger->slugifyShopCity($shop);

            $manager->flush();

            return $this->redirectToRoute('user_backoffice_shop_browse');
        }

        return $this->render('user_back_office/shop/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * 
     * Allow user to add one shop in his backoffice
     *
     * @route("/add", name="add")
     * 
     */
    public function add(EntityManagerInterface $manager, Request $request, Slugger $slugger)
    {
        $shop = new Shop;
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slugger->slugifyShopName($shop);
            $slugger->slugifyShopCity($shop);

            $manager->persist($shop);
            $manager->flush();

            return $this->redirectToRoute('user_backoffice_shop_browse');
        }

        return $this->render('user_back_office/shop/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
