<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class UserVoter extends Voter
{

    public function __construct(TokenInterface $tokenInterface, JWTTokenManagerInterface $jwtManager)
{
    $this->jwtManager = $jwtManager;
    $this->tokenInterface = $tokenInterface;
}
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['READ', 'EDIT', 'ADD'])
            && $subject instanceof \App\Entity\User; gi
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
                if($subject->getUser() === $user) {
                    return true;
                }


                break;
            case 'EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                if($subject->getUser() === $user) {
                    return true;
                }


                break;
            case 'ADD':
                // logic to determine if the user can EDIT
                // return true or false
                if($subject->getUser() === $user) {
                    return true;
                }



         
        }

        return false;
    }
}
