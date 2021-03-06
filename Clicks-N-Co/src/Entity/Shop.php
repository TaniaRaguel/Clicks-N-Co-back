<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=ShopRepository::class)
 */
class Shop
{
    /**
     * @Groups({"user_read", "product_read", "order_browse", "order_read", "shop_homeShop","shop_read", "shop_search", "shop_browse"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"user_read", "product_read", "order_browse", "order_read", "shop_homeShop", "shop_read", "shop_search", "shop_browse"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * 
     * @Groups({"shop_read"})
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @Groups({"shop_homeShop","shop_read","shop_search","shop_browse"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Groups({"shop_homeShop","shop_read","shop_search", "shop_browse"})
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @Groups({"shop_homeShop","shop_read", "shop_browse", "shop_search" })
     * @ORM\Column(type="string", length=64)
     */
    private $zip_code;

    /**
     * @Groups({"shop_homeShop","shop_read", "shop_browse", "shop_search"})
     * @ORM\Column(type="string", length=64)
     */
    private $city;

    /**
     * @Groups({"shop_homeShop","shop_read", "shop_browse", "shop_search" })
     * @ORM\Column(type="string", length=64)
     */
    private $city_slug;

    /**
     *  @Groups({"shop_homeShop","shop_read", "shop_browse", "shop_search"})
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Groups({"shop_read"})
     * @ORM\Column(type="string", length=32)
     */
    private $phone_number;

    /**
     * @Groups({"shop_read", "shop_search"})
     * @ORM\Column(type="string", length=128)
     */
    private $opening_hours;

    /**
     * @Groups({"shop_homeShop","shop_read", "shop_browse", "shop_search"})
     * @ORM\Column(type="string", length=255)
     */
    private $name_slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"shop_read"})
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="shop")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="shops")
     * @Groups({"shop_read", "shop_search"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="shop")
     */
    private $orders;

    /**
     * @Groups({"shop_homeShop","shop_search", "shop_read" ,"shop_browse"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCitySlug(): ?string
    {
        return $this->city_slug;
    }

    public function setCitySlug(string $city_slug): self
    {
        $this->city_slug = $city_slug;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->opening_hours;
    }

    public function setOpeningHours(string $opening_hours): self
    {
        $this->opening_hours = $opening_hours;

        return $this;
    }

    /**
     * Get the value of name_slug
     */
    public function getNameSlug(): ?string
    {
        return $this->name_slug;
    }

    /**
     * Set the value of name_slug
     *
     * @return  self
     */
    public function setNameSlug(string $name_slug): self
    {
        $this->name_slug = $name_slug;

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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setShop($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getShop() === $this) {
                $product->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setShop($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getShop() === $this) {
                $order->setShop(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
