<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Http\Validator\ShopValidator;
use App\Http\Validator\ValidatorAbstract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RequestParameterVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Regist Validate Group
        $validateGroup = [
            'shop' => ShopValidator::class
        ];

        try {
            $routeName = explode('.', Route::currentRouteName());
            $className = $routeName[0];
            if (empty($className) || !isset($validateGroup[$className])) {
                throw new ApiException(
                    500,
                    sprintf("Undefined validator : %s %s", $request->getMethod(), $request->getPathInfo())
                );
            }

            /**
             * @var ValidatorAbstract $validator
             */
            $validator = new $validateGroup[$className]();
            $validated = $validator->validate($request);

        } catch (ApiException $exception) {
            return $exception->render($request, $exception);
        }

        return $next($request);
    }

    private function rule(string $pathInfo)
    {
        switch ($pathInfo) {
            case '/proxy/v2/shop':
                return [
                    'mall_id' => 'required'
                ];
            case '/proxy/v2/product':
                return [
                    'mall_id' => 'required',
                    'shop_no' => 'required',
                ];
                break;
            case '/v1/shops':
                $validator = new ShopValidator();
                $validator->rule();
                break;
            default:
                return false;
                break;
        }
    }
}
