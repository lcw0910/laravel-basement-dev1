<?php
/**
 * Product.php
 *
 * @author cwlee02 <cwlee02@cafe24corp.com>
 * @since 2018-12-31
 * @version 1.0
 */

namespace App\Proxy\CAPIv2;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Product
{
    /**
     * @var Client $client Http Request Client
     */
    private $client;

    /**
     * @var array $credential CAPIv2 Credential
     */
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

    /**
     * @param array $params
     * @return ResponseInterface
     */
    public function search(array $params = []): ResponseInterface
    {
        $query = [
            'config' => [
                'offset' => $params['offset'] ?? 0,
                'limit'  => $params['limit'] ?? 10
            ],
            'condition' => [],
            'data' => $params['data'] ?: ['*'],
        ];
        foreach ($params as $key => $value) {
            $allowCondition = [
                'product_no',
                'product_code',
                'modify_date',
                'regist_date',
                'multi_shop',
            ];
            if (in_array($key, $allowCondition)) {
                switch ($key) {
                    case 'product_no':
                    case 'product_code':
                        $query['condition'][$key] = array_map(function ($value) {
                            return trim($value);
                        }, explode(',', $value));
                        break;
                    default:
                        $query['condition'][$key] = $value;
                        break;
                }
            }
        }
        $query = array_merge($this->credential, $query);
        $uri = sprintf(
            "https://%s.cafe24.com/openapi/product/v2/search?%s",
            $params['mall_id'],
            http_build_query($query)
        );
        return $this->client->get($uri);
    }
}