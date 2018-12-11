<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
//        Config::set('app.url', 'http://dev1-api.yicheolwon.xyz');

//        $response = $this->get('/order');
        $response = $this->call('GET', 'http://dev1-api.yicheolwon.xyz/order');

        Log::debug('Order::Get::Response', json_decode($response->getContent(), true));

        $response->assertStatus(200);
    }
}
