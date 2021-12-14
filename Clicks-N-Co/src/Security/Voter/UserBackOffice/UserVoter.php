<?php


namespace App\Security\Voter\UserBackOffice;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class UserVoter extends Voter
{

 
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['READ', 'EDIT', 'ADD'])

            && $subject instanceof \App\Entity\User; 
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {


        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
          return false;
        }
    
        switch ($attribute) {
          case 'READ':
          case 'EDIT':
          case 'ADD':
            // logic to determine if the user can READ
            // return true or false
            if ($subject === $user) {
              return true;
            }
            break;


        }

        return false;
    }
}
