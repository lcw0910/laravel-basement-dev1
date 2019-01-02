<?php

namespace App\Http\Controllers\Proxy\CAPI\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Shop extends Controller
{
    public function search(Request $request)
    {
        $params = $request->all();
        $capiShop = new \App\Proxy\CAPIv2\Shop();
        $response = $capiShop->search($params['mall_id']);
        $content = $response->getBody()->getContents();
        return \response($content, $response->getStatusCode(), ['Content-Type'  => 'application/json']);
    }
}
