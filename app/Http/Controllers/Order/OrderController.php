<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Orders;
use App\Model\OrderDetails;
use App\Model\Cart;
use Auth;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Orders::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        foreach ($order as $key => $value) {
            $count = 0;
            $value->orderDetails = $value->orderDetails;
            $value->userDetails = $value->users;
            $value->shippingAddress = $value->shippingAddress;
            foreach ($value->orderDetails as $keyO => $valueO) {
                $valueO->childProducts->getProduct->product_other_image = explode(',', $valueO->childProducts->getProduct->product_other_image);
                $value->childProducts = $valueO->childProducts;
                $value->getProduct = $valueO->childProducts->getProduct;
                $count += $valueO->quantity;
            }
            $value->quantity = $count;

        }
        
        return response()->json([
            'success'   => true,
            'data'      => $order,
            'message'   => 'Data found',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request->get('shipingId'));
        try {
            DB::beginTransaction();
            $order = Orders::create([
                'user_id'               => Auth::user()->id,
                'transaction_id'        => '',
                'shipping_address_id'   => $request->get('shipingId'),
                'order_number'          => md5(uniqid(rand(), true)),
                'status'                => 'ordered',
                'payment_method'        => $request->get('paymentMethod') == 'cod' ? 1 : 2,
                'ordered_at'            => date('Y-m-d H:i'),
                'sub_total'             => $request->get('subTotal'),
                'offer'                 => $request->get('couponCode'),
                'tax_collected'         => $request->get('tax'),
                'grand_total'           => $request->get('grandTotal'),
                'ip'                    => $request->ip(),
                'discount'              => $request->get('discount'),
            ]);
            DB::commit();
            foreach ($request->get('cartList') as $key => $value) {
                // return response()->json($value['price'] * $value['quantity']);
                OrderDetails::create([
                    'product_child_id'  => $value['productId'],
                    'order_id'          => $order->id,
                    'quantity'          => $value['quantity'],
                    'sub_total'         => $value['price'],
                    'grand_total'       => $value['price'] * $value['quantity'],
                ]);
                DB::commit();
            }
            Cart::where('user_id', Auth::user()->id)->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => $th->getMessage(),
                'data'      => [],
            ], 500);
            //throw $th;
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Data found',
            'data'      => $order,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Orders::whereId($id)->get();
        foreach ($order as $key => $value) {
            $count = 0;
            $value->orderDetails = $value->orderDetails;
            $value->userDetails = $value->users;
            $value->shippingAddress = $value->shippingAddress;
            foreach ($value->orderDetails as $keyO => $valueO) {
                $valueO->childProducts->getProduct->product_other_image = explode(',', $valueO->childProducts->getProduct->product_other_image);
                $value->childProducts = $valueO->childProducts;
                $value->getProduct = $valueO->childProducts->getProduct;
                $count += $valueO->quantity;
            }
            $value->quantity = $count;
        }

        return response()->json([
            'success'   => true,
            'data'      => $order,
            'message'   => 'Data found',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
