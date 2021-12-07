<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{

  /**
   * @Groups({"product_browse", "product_read", "order_read", "orderline_browse", "orderline_read", "shop_read"})
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @Groups({"product_browse", "product_read", "order_read", "orderline_browse", "orderline_read", "shop_read"})
   * @ORM\Column(type="string", length=255)
   */
  private $name;

  /**
   * @Groups({"product_read", "orderline_read", "shop_read"})
   * @ORM\Column(type="string", length=255)
   */
  private $description;

  /**
   * @Groups({"product_read", "orderline_browse", "orderline_read", "shop_read"})
   * @ORM\Column(type="string", length=64)
   */
  private $uc;

  /**
   * @Groups({"product_read", "orderline_browse", "orderline_read", "shop_read"})
   * @ORM\Column(type="float")
   */
  private $price;

  /**
   * @Groups({"product_read", "orderline_browse", "orderline_read", "shop_read"})
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $picture;

  /**
   * @Groups({"product_read"})
   * @ORM\Column(type="integer", options={"default":0})
   */
  private $stock;

  /**
   * @Groups({"product_read"})
   * @ORM\Column(type="datetime_immutable")
   */
  private $createdAt;

  /**
   * @Groups({"product_read"})
   * @ORM\Column(type="datetime_immutable", nullable=true)
   */
  private $updatedAt;

  /**
   * @Groups({"product_read"})
   * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="products")
   */
  private $tags;

  /**
   * @ORM\OneToMany(targetEntity=Orderline::class, mappedBy="product")
   */
  private $orderlines;

  /**
   * @Groups({"product_read"})
   * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="products")
   * @ORM\JoinColumn(nullable=false)
   */
  private $shop;

  public function __construct()
  {
    $this->createdAt = new \DateTimeImmutable();
    $this->tags = new ArrayCollection();
    $this->orderlines = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(string $description): self
  {
    $this->description = $description;

    return $this;
  }

  public function getUc(): ?string
  {
    return $this->uc;
  }

  public function setUc(string $uc): self
  {
    $this->uc = $uc;

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

  public function getPicture(): ?string
  {
    return $this->picture;
  }

  public function setPicture(?string $picture): self
  {
    $this->picture = $picture;

    return $this;
  }

  public function getStock(): ?int
  {
    return $this->stock;
  }

  public function setStock(int $stock): self
  {
    $this->stock = $stock;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * @return Collection|Tag[]
   */
  public function getTags(): Collection
  {
    return $this->tags;
  }

  public function addTag(Tag $tag): self
  {
    if (!$this->tags->contains($tag)) {
      $this->tags[] = $tag;

    }

    return $this;
  }

  public function removeTag(Tag $tag): self
  {
    $this->tags->removeElement($tag);

    return $this;
  }

  /**
   * @return Collection|Orderline[]
   */
  public function getOrderlines(): Collection
  {
    return $this->orderlines;
  }

  public function addOrderline(Orderline $orderline): self
  {
    if (!$this->orderlines->contains($orderline)) {
      $this->orderlines[] = $orderline;
      $orderline->setProduct($this);
    }

    return $this;
  }

  public function removeOrderline(Orderline $orderline): self
  {
    if ($this->orderlines->removeElement($orderline)) {
      // set the owning side to null (unless already changed)
      if ($orderline->getProduct() === $this) {
        $orderline->setProduct(null);
      }
    }

    return $this;
  }

  public function getShop(): ?Shop
  {
    return $this->shop;
  }

  public function setShop(?Shop $shop): self
  {
    $this->shop = $shop;

    return $this;
  }
}
