<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Form\UserType;
use App\Service\ImageUploader;
use App\Service\Mailer;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/users", name="api_v1_users_", requirements={"id"="\d+"})
 */
class UserController extends AbstractController
{


  /**
   * @Route("", name="add", methods={"POST"})
   */
  public function add(EntityManagerInterface $manager, Request $request, Slugger $slugger, UserPasswordHasherInterface $userPasswordHasher, Mailer $mailer): Response
  {
    $user = new User;

    $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);

    $jsonArray = json_decode($request->getContent(), true);

    $form->submit($jsonArray);

    if ($form->isValid()) {

      $password = $jsonArray['password'];
      $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
      $user->setPassword($hashedPassword);

      $user->setRoles(['ROLE_USER']);

      $slugger->slugifyUserCity($user);

      $manager->persist($user);
      $manager->flush();
      
      // $mailer->sendEmailNewUser($user);

      return $this->json($user, 201);
    }

    $errorMessages = [];
    foreach ($form->getErrors(true) as $error) {
      $errorMessages[] = [
        'property' => $error->getOrigin()->getName(),
        'message' => $error->getMessage(),
      ];
    }
    return $this->json($errorMessages, 400);
  }

  /**
   * 
   * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
   * 
   */
  public function edit(EntityManagerInterface $manager, Request $request, Slugger $slugger, User $user, UserPasswordHasherInterface $userPasswordHasher, ImageUploader $imageUploader): Response
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

      $picture = ($request->files->all()['user']['picture']);
      if ($picture) {
        $imageUploader->uploadUserImage($form);
      }

      $manager->flush();

      return $this->json($user, 200);
    }

    $errorMessages = [];
    foreach ($form->getErrors(true) as $error) {
      $errorMessages[] = [
        'property' => $error->getOrigin()->getName(),
        'message' => $error->getMessage(),
      ];
    }

    return $this->json($errorMessages, 400);
  }

  /**
   * @Route("/{id}", name="read", methods={"GET"})
   */
  public function read(User $user): Response
  {
    $this->denyAccessUnlessGranted('ADD', $user);

    return $this->json($user, 200, [], [
      'groups' => ['user_read'],
    ]);
  }
  
}
