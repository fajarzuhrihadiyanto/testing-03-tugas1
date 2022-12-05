<?php

namespace App\Http\Controllers;

use App\Services\CreateShop\CreateShopRequest;
use App\Services\CreateShop\CreateShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use function use_db_transaction;

class ShopController extends Controller
{
    /**
     * @throws Throwable
     */
    public function createShop(Request $request, CreateShopService $service): JsonResponse
    {
        use_db_transaction(fn () => $service->execute(new CreateShopRequest($request->input('name')), $request->user()));
        return $this->success();
    }
}
