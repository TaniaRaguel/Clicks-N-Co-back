<?php

namespace App\Security\Voter\UserBackOffice;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderVoter extends Voter
{

     public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['READ', 'EDIT', 'ADD'])
            && $subject instanceof \App\Entity\Order;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenInterface->getToken());
        $user = $decodedJwtToken->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'READ':
                // logic to determine if the user can EDIT
                // return true or false

                if (!$user instanceof UserInterface) {
            return false;
        }
                break;
            case 'EDIT':
                // logic to determine if the user can VIEW
                // return true or false

                if (!$user instanceof UserInterface) {
                    return false;
                }
               
                break;
            case 'ADD':
                // logic to determine if the user can VIEW
                // return true or false

                if (!$user instanceof UserInterface) {
                    return false;
                }
                break;
        }

        return false;
    }
}
