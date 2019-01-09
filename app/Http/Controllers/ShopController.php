<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use Exception;
use App\Http\Validator\ShopValidator;
use App\Models\Shop;
use App\Proxy\CAPIv2\Shop as ProxyShopV2;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * @var ShopValidator $validator
     */
    private $validator;

    public function __construct(ShopValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws Exception
     */
    public function regist(Request $request)
    {
        $params = $this->validator->validate($request);
        $shopApi = new ProxyShopV2();
        $response = $shopApi->search($params['mall_id']);

        switch (round($response->getStatusCode() / 100, 0)) {
            case floatval(4):
            case floatval(5):
                throw new ClientException('CAPIv2 Error', null, $response);
                break;
        }

        $contents = json_decode($response->getBody()->getContents(), true);
        if (! isset($contents['response']['result']) || count($contents['response']['result']) === 0) {
            return response(['message' => 'The shop does not exists.'], 200);
        }

        $shops = [];
        foreach ($contents['response']['result'] as $shop) {
            $shops[] = [
                'mall_id'           => $params['mall_id'],
                'shop_no'           => $shop['shop_no'],
                'is_default'        => $shop['is_defaultshop'] === 'T' ? 1 : 0,
                'locale'            => $shop['language'],
                'locale_name'       => $shop['language_name'],
                'currency'          => $shop['currency'],
                'currency_name'     => html_entity_decode($shop['currency_name']),
                'sub_currency'      => $shop['sub_currency'],
                'sub_currency_name' => html_entity_decode($shop['sub_currency_name']),
                'timezone'          => $shop['timezone'],
                'default_skin_no'   => $shop['default_skin_no'],
                'default_mobile_skin_no'    => $shop['default_mobile_skin_no'],
                'is_active'                 => $shop['is_active'] === 'T' ? 1 : 0
            ];
        }

        // Batch Insert
        if (Shop::insert($shops) === false) {
            throw new Exception('Internal Error', 500);
        }

        // Response : 201 Created
        return response()->json($shops, 201);
    }

    /**
     * @param int $id
     * @return Response|\Illuminate\Support\Collection
     * @throws ApiException
     */
    public function findOne(int $id)
    {
        $result = DB::table('shops')->where('id', $id)->get();
        if ($result->count() === 0) {
            return response()->noContent();
        }
        return $result;
    }
}
