<?php

namespace App\Http\Controllers\Proxy\CAPI\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class Product extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $params = $request->all();
        $capiProduct = new \App\Proxy\CAPIv2\Product();
        $response = $capiProduct->search($params);
        $content = $response->getBody()->getContents();
        return \response($content, $response->getStatusCode(), ['Content-Type'  => 'application/json']);
    }
}
