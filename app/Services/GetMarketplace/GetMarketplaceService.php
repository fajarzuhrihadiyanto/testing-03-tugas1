<?php

namespace App\Services\GetMarketplace;

use App\Models\Shop;
use App\Models\User;

class GetMarketplaceService
{
    public function execute(GetMarketplaceRequest $request, User $user)
    {
        $query = Shop::where('shop_id', $request->getShopId());
        if ($request->getShopId() && $request->getId()) return $query->where('id', $request->getId())->first();
        if ($request->getShopId()) return $query->get();
        return [];
    }
}
