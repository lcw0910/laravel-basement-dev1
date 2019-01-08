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
            ]
        ];
        if (! isset($rules[$routeName])) {
            throw new ApiException(500, sprintf("undefined validator rule : %s", $routeName));
        }
        return $rules[$routeName];
    }
}
