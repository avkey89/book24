<?php

namespace App\Tests\Services;

use App\Services\SearchInArray;
use PHPUnit\Framework\TestCase;

class SearchInArrayTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testFindNumFalse()
    {
        ini_set("memory_limit", "550M");
        $searchInArray = new SearchInArray();
        $result = $searchInArray->findNum(range(1, 10000000, 2), 6562848);
        $this->assertFalse($result);
    }

    public function testFindNumTrue()
    {
        ini_set("memory_limit", "550M");
        $searchInArray = new SearchInArray();
        $result = $searchInArray->findNum(range(1, 10000000), 6562848);
        $this->assertTrue($result);
    }
}
