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
  public function sendEmailNewOrderTrader(Order $order)
  {
    $user = $order->getUser();
    $firstName = $user->getFirstname();
    $lastname = $user->getLastname();

    $orderId = $order->getId();

    $shop = $order->getShop();
    $shopEmail = $shop->getEmail();
    $shopName = $shop->getName();

    $email = (new Email())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($shopEmail)
      ->subject('Nouvelle commande Clicks N Co !')
      // ->text('Allez voir dans votre espace magasin ! Une nouvelle commande est arrivée !')
      ->html('<h1>Nouvelle commande <strong>REF' . $orderId . '</strong> !</h1><br><h2>Bonjour ' . $shopName . ',</h2><br><p>Nous avons enregistré la commande <strong>REF' . $orderId . '</strong> pour votre client <strong>' . $firstName . ' ' . $lastname . '</strong>.</p><br><p>Vous pouvez, dès à présent, retrouver le détail de votre commande dans votre espace espace magasin.</p><br><p>À bientôt,</p><p>L\'équipe <strong>Clicks N Co</p></strong>');

    $this->mailer->send($email);
  }

  public function sendEmailNewOrderCustomer(Order $order)
  {
    $user = $order->getUser();
    $firstName = $user->getFirstname();
    $lastname = $user->getLastname();
    $userEmail = $user->getEmail();

    $orderId = $order->getId();
    $totalPrice = $order->getTotalPrice();

    $shop = $order->getShop();
    $shopName = $shop->getName();

    $email = (new Email())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($userEmail)
      ->subject('Récupitulatif de votre commande Click N Co !')
      // ->text('Votre commande a été transmise à votre commerçant')
      ->html('<h1>Votre commande <strong>REF' . $orderId . '</strong> est transmise à <strong>' . $shopName . '</strong> !</h1><br><h2>Bonjour <strong>' . $firstName . ' ' . $lastname . '</strong>,</h2><br><p>Votre commande <strong>REF' . $orderId . '</strong> a bien été transmise à <strong>' . $shopName . '</strong>.</p><br><p>Vous pouvez, dès à présent, retrouver le détail de votre commande dans votre espace espace client.</p><br><h2>Récapitulatif de votre commande</h2><br><p><strong><span style="margin-right: 50px">REF' . $orderId . '</span><span style="margin-right: 50px">' . $shopName . '</span><span style="margin-right: 50px">Prix Total ' . $totalPrice . ' Euros</span></strong></p><br><p>À bientôt,</p><p>L\'équipe <strong>Clicks N Co</strong></p>');

    $this->mailer->send($email);
  }

  public function sendReadyOrder(Order $order)
  {
    $user = $order->getUser();
    $firstName = $user->getFirstname();
    $lastname = $user->getLastname();
    $userEmail = $user->getEmail();

    $orderId = $order->getId();

    $shop = $order->getShop();
    $shopName = $shop->getName();
    $shopOpeningHours = $shop->getOpeningHours();
    $shopAdress = $shop->getAddress();
    $shopZipCode = $shop->getZipCode();
    $shopCity = $shop->getCity();

    $email = (new Email())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($userEmail)
      ->subject('Votre commande est prête !')
      // ->text('Votre commande est prête ! Vous pouvez la retirer !')
      ->html('<h1>Votre commande <strong>REF' . $orderId . '</strong> est disponible !</h1><br><h2>Bonjour <strong>' . $firstName . ' ' . $lastname . '</strong>,</h2><br><p>Votre commande <strong>REF' . $orderId . '</strong> est disponible chez <strong>' . $shopName . '</strong>.</p><br><p>Vous pouvez la retirer.</p><br><h2>Horaires d\'ouvertures et adresse de ' . $shopName . '</h2><br><p><strong>' . $shopOpeningHours . '</strong></p><p><strong>' . $shopName . '</strong></p><p><strong>' . $shopAdress . '</strong></p><p><strong>' . $shopZipCode . ' ' . $shopCity . '</strong></p><br><p>À bientôt,</p><p>L\'équipe <strong>Clicks N Co</strong></p>');

    $this->mailer->send($email);
  }
}
