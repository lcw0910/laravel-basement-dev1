<?php
/**
 * ValidatorAbstract.php
 *
 * @author cwlee02 <cwlee02@cafe24corp.com>
 * @since 2019-01-07
 * @version 1.0
 */

namespace App\Http\Validator;


use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

abstract class ValidatorAbstract
{
    abstract public function rule(string $routeName): array;

    /**
     * @param Request $request
     * @return array
     * @throws ApiException
     */
    public function validate(Request $request)
    {
        $routeName = Route::currentRouteName();
        $validator = Validator::make($request->all(), $this->rule($routeName));
        if ($validator->fails()) {
            $message = 'Invalid Argument';
            $errors = [
                'message'   => $message,
                'errors'    => $validator->errors()->toArray()
            ];
            Log::error($message, $errors);
            throw new ApiException(400, $message, $errors);
        }
        return $validator->validate();
    }
}
