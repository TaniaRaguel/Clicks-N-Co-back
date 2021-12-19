<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\Slugger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\AsciiSlugger;

class SluggerTest extends TestCase
{
    public function testSlugify(): void
    {
      $slugger = new Slugger(new AsciiSlugger());

      $sluggedString = $slugger->slugify('   Hi Clicks N Co ! What a wonderful app !    ');

      $this->assertIsString($sluggedString);

      $this->assertEquals('hi-clicks-n-co-what-a-wonderful-app', $sluggedString);
    }

    public function testSlugifyUserCity()
    {
        $slugger = new Slugger(new AsciiSlugger());


        $user = new User();
        $user->setCity(' Clicks N Co City ');

        $result = $slugger->slugifyUserCity($user);

        $this->assertNull($result);

        $this->assertEquals('clicks-n-co-city', $user->getCitySlug());


    }
}
