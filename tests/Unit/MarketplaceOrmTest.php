<?php

use App\Models\Marketplace;
use Carbon\Carbon;
use Tests\TestCase;

class MarketplaceOrmTest extends TestCase
{
    public function testCanBuildMarketplace(): Marketplace
    {
        $now = Carbon::parse('now')->toDateTime();
        $marketplace = new Marketplace([
            'id' => 1,
            'shop_id' => 1,
            'name' => 'ini nama market place',
            'created_at' => $now
        ]);
        $this->assertTrue($marketplace->getId() == 1);
        $this->assertTrue($marketplace->getShopId() == 1);
        $this->assertTrue($marketplace->getName() == 'ini nama market place');
        $this->assertEqualsWithDelta($marketplace->getCreatedAt()->format('Y-m-d H:i:s'), $now->format('Y-m-d H:i:s'), 1, '');
        return $marketplace;
    }

    /**
     * @depends testCanBuildMarketplace
     * @param Marketplace $marketplace
     * @return Marketplace
     */
    public function testCanPersist(Marketplace $marketplace): Marketplace
    {
        $this->expectNotToPerformAssertions();
        Marketplace::persist($marketplace);

        return $marketplace;
    }

    /**
     * @depends testCanPersist
     * @param Marketplace $marketplace
     * @return void
     */
    public function testCanFind(Marketplace $marketplace): void
    {
        $found_marketplace = Marketplace::where('id', $marketplace->getId())->first();
        $this->assertTrue($marketplace->getId() == $found_marketplace->getId());
        $this->assertTrue($marketplace->getShopId() == $found_marketplace->getShopId());
        $this->assertTrue($marketplace->getName() == $found_marketplace->getName());
        $this->assertEqualsWithDelta($marketplace->getCreatedAt()->format('Y-m-d H:i:s'), $found_marketplace->getCreatedAt()->format('Y-m-d H:i:s'), 1, '');

        $found_marketplace->delete();

    }

    protected function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();
    }

    protected function tearDown(): void
    {
        Schema::enableForeignKeyConstraints();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}
