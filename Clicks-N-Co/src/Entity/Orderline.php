<?php

namespace App\Entity;

use App\Repository\OrderlineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderlineRepository::class)
 */
class Orderline
{
    /**
     * @Groups({"orderline_browse", "orderline_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"orderline_browse", "orderline_read"})
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @Groups({"orderline_browse", "orderline_read"})
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Groups({"orderline_browse", "orderline_read"})
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orderlines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @Groups({"orderline_browse", "orderline_read"})
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderlines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderRef;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrderRef(): ?Order
    {
        return $this->orderRef;
    }

    public function setOrderRef(?Order $orderRef): self
    {
        $this->orderRef = $orderRef;

        return $this;
    }
}
