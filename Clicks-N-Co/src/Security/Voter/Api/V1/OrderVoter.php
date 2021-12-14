<?php

namespace App\Security\Voter\Api\V1;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderVoter extends Voter
{
  protected function supports(string $attribute, $subject): bool
  {
    // replace with your own logic
    // https://symfony.com/doc/current/security/voters.html
    return in_array($attribute, ['READ', 'EDIT', 'ADD', 'DELETE'])
      && $subject instanceof \App\Entity\Order;
  }

  protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
  {
    $user = $token->getUser();
    // if the user is anonymous, do not grant access
    if (!$user instanceof UserInterface) {
      return false;
    }

    // ... (check conditions and return true to grant permission) ...
    switch ($attribute) {
      case 'READ':
      case 'EDIT':
      case 'ADD':
      case 'DELETE':
        // logic to determine if the user can READ
        // return true or false
        if ($subject->getUser() === $user) {
          return true;
        }
        break;
    }

    return false;
  }
}
