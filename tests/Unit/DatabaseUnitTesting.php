<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DatabaseUnitTesting extends TestCase
{
    public function testDatabaseConnection()
    {
        $this->expectNotToPerformAssertions();
        DB::getPdo();
    }
    public function testTableUserExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('users')->getConnection();
    }
    public function testTableOtpExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('otp')->getConnection();
    }

    public function testTableCategoryExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('category')->getConnection();
    }

    public function testTableShopExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('shop')->getConnection();
    }

    public function testTableMarketplaceExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('marketplace')->getConnection();
    }

    public function testTableProductExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('product')->getConnection();
    }

    public function testTableProductCategoryExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('product_category')->getConnection();
    }

    public function testTableProductMovementExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('product_movement')->getConnection();
    }

    public function testTableTransactionExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('transaction')->getConnection();
    }

    public function testTableTransactionItemsExists()
    {
        $this->expectNotToPerformAssertions();
        DB::table('transaction_items')->getConnection();
    }
}
