<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{

  public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
  {
    $this->jwtManager = $jwtManager;
    $this->tokenStorageInterface = $tokenStorageInterface;
  }
  /**
   * @Route("/Api/V1/login", name="api_login", methods={"POST"})
   */
  public function index(Security $security): Response
  {
    $user = $security->getUser();

    if (null === $user) {
      return $this->json([
        'message' => 'missing credentials',
      ], Response::HTTP_UNAUTHORIZED);
    }

    $token = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

    return $this->json([
      'user'  => $user->getUserIdentifier(),
      'token' => $token,
    ]);
  }
}
