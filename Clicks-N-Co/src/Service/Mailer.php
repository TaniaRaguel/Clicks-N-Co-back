<?php

namespace App\Service;

use App\Entity\Order;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
  private $mailer;

  public function __construct(MailerInterface $mailer)
  {
    $this->mailer = $mailer;
  }
  public function sendEmailNewOrder(Order $order)
  {
    $shopEmail = $order->getShop()->getEmail();

    $email = (new Email())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($shopEmail)
      ->subject('Vous avez une nouvelle commande')
      ->text('Allez voir dans votre espace magasin ! Une nouvelle commande est arrivée !');
    // ->html('<p>See Twig integration for better HTML integration!</p>');

    $this->mailer->send($email);
  }

  public function sendReadyOrder(Order $order)
  {
    $userEmail = $order->getUser()->getEmail();

    $email = (new Email())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($userEmail)
      ->subject('Votre commande est prête')
      ->text('Votre commande est prête ! Vous pouvez la retirer !');
    // ->html('<p>See Twig integration for better HTML integration!</p>');

    $this->mailer->send($email);
  }
}
