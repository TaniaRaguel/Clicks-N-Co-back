<?php

namespace App\Service;

use App\Entity\Shop;
use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;

class Slugger
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     *
     * Return the slug of a string
     *
     * @param string $stringToSlugify
     * @return string
     */
    public function slugify(string $stringToSlugify):string
    {
        
        return strtolower($this->slugger->slug($stringToSlugify));
    }

    /**
     *
     * Return the slug of the user's city
     *
     * @param User $user
     * @return void
     */
    public function slugifyUserCity(User $user)
    {
        $city = $user->getCity();
        $slug = $this->slugify($city);

        $user->setCitySlug($slug);
    }

    /**
     *
     * Return the slug of the shop's city
     *
     * @param Shop $shop
     * @return void
     */
    public function slugifyShopCity(Shop $shop)
    {
        $city = $shop->getCity();
        $slug = $this->slugify($city);

        $shop->setCitySlug($slug);
    }

    /**
     *
     * Return the slug of the shop's name
     *
     * @param Shop $shop
     * @return void
     */
    public function slugifyShopName(Shop $shop)
    {
        $name = $shop->getName();
        $slug = $this->slugify($name);

        $shop->setName_slug($slug);
    }
}