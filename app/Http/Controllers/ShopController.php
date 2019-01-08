<?php

namespace App\Http\Controllers;

use App\Proxy\CAPIv2\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function regist(Request $request)
    {
        $shopApi = new Shop();
        $response = $shopApi->search($request->get('mall_id'));

        $contents = json_decode($response->getBody()->getContents(), true);
        return response()->json($contents);
    }
}
