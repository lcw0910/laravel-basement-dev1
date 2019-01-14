<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShopRegist()
    {
        $this->assertTrue(true);

        // Test : Required parameter is missing
        $params = [];
        $response = $this->call('POST', 'http://dev1-api.yicheolwon.xyz/v1/shops', $params);
        $response->assertStatus(400);
        $response->assertJson([
            'message'   => 'Invalid Argument',
            'errors'    => [
                'mall_id'   => ['The mall id field is required.']
            ]
        ], true);

        // Test Does not exists shop information.
        $params = ['mall_id' => 'unknown_shops'];
        $response = $this->call('POST', 'http://dev1-api.yicheolwon.xyz/v1/shops', $params);
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'CAPIv2 Client Error'
        ], true);

        // Test Regist Shop Success
        $params = ['mall_id' => 'bpmt001'];
        $response = $this->call('POST', 'http://dev1-api.yicheolwon.xyz/v1/shops', $params);
        $response->assertStatus(201);
    }
}
