<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $headers;

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $orders = DB::table('orders')->get();
        $orders = Order::all();

        return new Response([
            'orders'    => $orders,
            'message'   => sprintf("This is %s method", __FUNCTION__)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $requestBody = $request->only([
            'order_no',
            'product_no'
        ]);

        // Define Validate Rules
        $rules = [
            'order_no'      => 'required|integer',
            'product_no'    => 'required|integer'
        ];

        $validator = Validator::make($requestBody, $rules);


        /*$validator->sometimes(['product_no'], 'required|max:100', function ($input) {
            return $input->order_no > 100;
        });

        $validator->after(function ($validator) {
            $validator->errors()->add('product_no', 'added error message');
        });*/

        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }


        $result = Order::updateOrCreate(
            ['product_no' => 1],
            [
                'order_no'  => 2,
                'product_no' => 1,

            ]
        );

        $response = [
            'result' => $result->wasRecentlyCreated ? 'created' : 'updated',
        ];
        if ($result->wasRecentlyCreated) {
            $response['data'] = $result->getOriginal();
        } else {
            if (empty($result->getChanges())) {
                $response['result'] = 'nothing';
            } else {
                $response['data'] = $result->getChanges();
            }
        }

        Log::info('Order::store::success', $response);

        return new Response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new Response(['message' => sprintf("This is %s method", __FUNCTION__)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return new Response(['message' => sprintf("This is %s method", __FUNCTION__)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return new Response(['message' => sprintf("This is %s method", __FUNCTION__)]);
    }
}
