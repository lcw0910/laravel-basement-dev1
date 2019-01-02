<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

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
        $rule = $this->rule($request->getPathInfo());
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response($validator->errors()->toJson(), 400, ['Content-Type' => 'application/json']);
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
            default:
                return false;
                break;
        }
    }
}
