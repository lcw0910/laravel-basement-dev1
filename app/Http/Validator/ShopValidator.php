<?php
/**
 * ShopValidator.php
 *
 * @author cwlee02 <cwlee02@cafe24corp.com>
 * @since 2019-01-04
 * @version 1.0
 */

namespace App\Http\Validator;

use App\Exceptions\ApiException;

class ShopValidator extends ValidatorAbstract
{
    /**
     * @param string $routeName
     * @return array
     * @throws ApiException
     */
    public function rule(string $routeName): array
    {
        $rules = [
            'shop.regist' => [
                'mall_id' => 'required'
            ],
            'shop.findMany' => [
                'id'                => 'required_without:mall_id',
                'mall_id'           => 'required_without:id',
                'shop_no'           => 'integer',
                'created_at.*'      => 'date',
                'created_at.lt'     => 'date|before:created_at.gt',
                'created_at.gt'     => 'date|after:created_at.lt',
                'created_at.lte'    => 'date|before_or_equal:created_at.gte',
                'created_at.gte'    => 'date|after_or_equal:created_at.lte',
            ]
        ];
        if (! isset($rules[$routeName])) {
            throw new ApiException(500, sprintf("undefined validator rule : %s", $routeName));
        }
        return $rules[$routeName];
    }
}
