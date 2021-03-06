<?php

namespace App\Controller\UserBackOffice;

use App\Entity\Shop;
use App\Entity\User;
use App\Form\ShopType;
use App\Service\ImageUploader;
use App\Service\Slugger;
use DateTimeImmutable;
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
     * Show details of one user's shop
     * 
     * @Route("/{name_slug}", name="read")
     */
    public function read(Shop $shop): Response
    {
        $user = $shop->getUser();

        $this->denyAccessUnlessGranted('READ', $user);

        $orders = $shop->getOrders();
        $ordersToPrepare = [];

        foreach ($orders as $order) {
            if ($order->getStatus() == 0) {
                $ordersToPrepare[] = $order;
            }
        }

        return $this->render('user_back_office/shop/read.html.twig', [
            'shop' => $shop,
            'user' => $user,
            'products' => $shop->getProducts(),
            'orders' => $ordersToPrepare,

        ]);
    }

    /**
     * 
     * Allow user to edit one shop in his backoffice
     *
     * @route("/edit/{name_slug}", name="edit")
     * 
     */
    public function edit(EntityManagerInterface $manager, Request $request, Shop $shop, Slugger $slugger, ImageUploader $imageUploader)
    {


        $user = $shop->getUser();

        $this->denyAccessUnlessGranted('EDIT', $user);



        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = ($request->files->all()['shop']['picture']);

            if ($picture) {
                $imageUploader->uploadShopImage($form);
            }

            $slugger->slugifyShopName($shop);
            $slugger->slugifyShopCity($shop);
            $shop->setUpdatedAt(new \DateTimeImmutable());

            $manager->flush();

            return $this->redirectToRoute('user_backoffice_shop_read', [
                'id' => $user->getId(),
                'name_slug' => $shop->getNameSlug(),
            ]);
        }

        return $this->render('user_back_office/shop/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'shop' => $shop,
        ]);
    }

    /**
     * 
     * Allow user to add one shop in his backoffice
     *
     * @route("/{id}/add", name="add")
     * 
     */
    public function add(EntityManagerInterface $manager, Request $request, Slugger $slugger, User $user, ImageUploader $imageUploader)

    {
        $shop = new Shop;

        $this->denyAccessUnlessGranted('ADD', $user);

        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageUploader->uploadShopImage($form);

            $slugger->slugifyShopName($shop);
            $slugger->slugifyShopCity($shop);
            $shop->setUser($user);

            $manager->persist($shop);
            $manager->flush();

            return $this->redirectToRoute('user_backoffice_user_read', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user_back_office/shop/add.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
