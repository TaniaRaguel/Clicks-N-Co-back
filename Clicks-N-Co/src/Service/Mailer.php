<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
  private $mailer;

  public function __construct(MailerInterface $mailer)
  {
    $this->mailer = $mailer;
  }

  public function sendEmailNewUser(User $user)
  {

    $firstName = $user->getFirstname();
    $lastName = $user->getLastname();
    $userEmail = $user->getEmail();


    $email = (new TemplatedEmail())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($userEmail)
      ->subject('Bienvenue sur Clicks N Co !')
      ->embedFromPath('images/logo/icon.png', 'logo')
      ->htmlTemplate('emails/new_user.html.twig')
      ->context([
        'logo' => 'logo',
        'firstname' => $firstName,
        'lastname' => $lastName,
      ]);
    $this->mailer->send($email);
  }
  public function sendEmailNewOrderTrader(Order $order)
  {
    $user = $order->getUser();
    $firstName = $user->getFirstname();
    $lastName = $user->getLastname();

    $orderId = $order->getId();

    $shop = $order->getShop();
    $shopEmail = $shop->getEmail();
    $shopName = $shop->getName();

    $email = (new TemplatedEmail())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($shopEmail)
      ->subject('Nouvelle commande Clicks N Co !')
      ->embedFromPath('images/logo/icon.png', 'logo')
      ->htmlTemplate('emails/new_order_trader.html.twig')
      ->context([
        'logo' => 'logo',
        'firstname' => $firstName,
        'lastname' => $lastName,
        'orderid' => $orderId,
        'shopname' => $shopName,
      ]);
    $this->mailer->send($email);
  }

  public function sendEmailNewOrderCustomer(Order $order)
  {
    $user = $order->getUser();
    $firstName = $user->getFirstname();
    $lastName = $user->getLastname();
    $userEmail = $user->getEmail();

    $orderId = $order->getId();
    $totalPrice = $order->getTotalPrice();

    $shop = $order->getShop();
    $shopName = $shop->getName();

    $email = (new TemplatedEmail())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($userEmail)
      ->subject('Récupitulatif de votre commande Click N Co !')
      ->embedFromPath('images/logo/icon.png', 'logo')
      ->htmlTemplate('emails/new_order_customer.html.twig')
      ->context([
        'logo' => 'logo',
        'firstname' => $firstName,
        'lastname' => $lastName,
        'orderid' => $orderId,
        'shopname' => $shopName,
        'totalprice' => $totalPrice,
      ]);
    $this->mailer->send($email);
  }

  public function sendReadyOrder(Order $order)
  {
    $user = $order->getUser();
    $firstName = $user->getFirstname();
    $lastName = $user->getLastname();
    $userEmail = $user->getEmail();

    $orderId = $order->getId();

    $shop = $order->getShop();
    $shopName = $shop->getName();
    $shopOpeningHours = $shop->getOpeningHours();
    $shopAdress = $shop->getAddress();
    $shopZipCode = $shop->getZipCode();
    $shopCity = $shop->getCity();

    $email = (new TemplatedEmail())
      ->from('clicksnco@gmail.com')
      ->to('clicksnco-d601f7@inbox.mailtrap.io')
      ->cc($userEmail)
      ->subject('Votre commande est prête !')
      ->embedFromPath('images/logo/icon.png', 'logo')
      ->htmlTemplate('emails/ready_order.html.twig')
      ->context([
        'logo' => 'logo',
        'firstname' => $firstName,
        'lastname' => $lastName,
        'logo' => 'logo',
        'firstname' => $firstName,
        'lastname' => $lastName,
        'orderid' => $orderId,
        'shopname' => $shopName,
        'shopopeninghours' => $shopOpeningHours,
        'shopadress' => $shopAdress,
        'shopzipcode' => $shopZipCode,
        'shopcity' => $shopCity,
      ]);

    // ->html('<h1>Votre commande <strong>REF' . $orderId . '</strong> est disponible !</h1><br><h2>Bonjour <strong>' . $firstName . ' ' . $lastname . '</strong>,</h2><br><p>Votre commande <strong>REF' . $orderId . '</strong> est disponible chez <strong>' . $shopName . '</strong>.</p><br><p>Vous pouvez la retirer.</p><br><h2>Horaires d\'ouvertures et adresse de ' . $shopName . '</h2><br><p><strong>' . $shopOpeningHours . '</strong></p><p><strong>' . $shopName . '</strong></p><p><strong>' . $shopAdress . '</strong></p><p><strong>' . $shopZipCode . ' ' . $shopCity . '</strong></p><br><p>À bientôt,</p><p>L\'équipe <strong>Clicks N Co</strong></p>');

    $this->mailer->send($email);
  }
}
