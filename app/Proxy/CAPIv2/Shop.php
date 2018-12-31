<?php
/**
 * Shop.php
 *
 * @author cwlee02 <cwlee02@cafe24corp.com>
 * @since 2018-12-31
 * @version 1.0
 */

namespace App\Proxy\CAPIv2;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Shop
{
    private $client;

    protected $credential = [];

    public function __construct()
    {
        $this->credential = [
            'client_id'     => env('CAPI_V2_CLIENT_ID'),
            'client_secret' => env('CAPI_V2_CLIENT_SECRET'),
            'scope'         => env('CAPI_V2_SCOPE'),
            'manager_id'    => env('CAPI_V2_MANAGER_ID')
        ];

        $this->client = new Client([
            'timeout'           => 30,
            'allow_redirects'   => false,
            'verify'            => false
        ]);
    }

    public function search(string $mallId = ''): ResponseInterface
    {
        $query = http_build_query($this->credential);
        $uri = sprintf(
            "https://%s.cafe24.com/openapi/shop/v2/getmultishopinfo?%s",
            $mallId,
            $query
        );
        return $this->client->get($uri);
    }
}