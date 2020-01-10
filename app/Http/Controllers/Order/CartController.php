<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use Auth;
use DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'success'   => true,
            'data'      => $cart,
        ], 201);
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
        try {
            DB::beginTransaction();
            $isProductExist = Cart::where('product_child_id', $request->get('productId'))->where('user_id', Auth::user()->id)->first();
            if ($isProductExist) {
                // update
                Cart::where('id', $isProductExist->id)->update([
                    'quantity'  => $request->get('quantity') ? $request->get('quantity') : $isProductExist->quantity + 1,
                    'price'     => $request->get('price'),
                    'date'      => date('Y-m-d h:i'),
                    'cartData'  => json_encode($request->get('productData')),
                ]);
            } else {
                // create
                $isProductExist = Cart::create([
                    'user_id'       => Auth::user()->id,
                    'product_child_id'   =>  $request->get('productId'),
                    'quantity'  =>  $request->get('quantity') ? $request->get('quantity') : 1,
                    'date'      => date('Y-m-d h:i'),
                    'cartData'  => json_encode($request->get('productData')),
                    'price'     => $request->get('price'),
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'data'      => [],
                'message'   => $th->getMessage(),
            ], 500);
        }
        return response()->json([
            'success'   => true,
            'data'      => Cart::where('user_id', Auth::user()->id)->get(),
            'message'   => 'Data found',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            DB::beginTransaction();
            $cart = Cart::where('user_id', Auth::user()->id)->where('product_child_id', $id)->first();
            if($cart->quantity > 1) {
                Cart::where('id', $cart->id)->update(['quantity' => $cart->quantity - 1, ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'data'      => $th->getMessage(),
                'message'   => 'Data not found',
            ], 500);
        }
        return response()->json([
            'success'   => true,
            'data'      => Cart::where('user_id', Auth::user()->id)->get(),
            'message'   => 'Data found',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->where('product_child_id', $id)->first();
        try {
            if ($cart) {
                Cart::destroy($cart->id);
            } else {
                return response()->json([
                    'success'   => true,
                    'data'      => [],
                    'message'   => 'Data not found',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'data'      => [],
                'message'   => $th->getMessage(),
            ], 500);
        }
        return response()->json([
            'success'   => true,
            'data'      => Cart::where('user_id', Auth::user()->id)->get(),
            'message'   => 'Data found',
        ], 200);
    }


    public function storage(Request $request)
    {
        try {
            DB::beginTransaction();
            if (count($request->get('cart')) > 0) {
                foreach ($request->get('cart') as $key => $value) {
                    $isProductExist = Cart::where('product_child_id', $value['productId'])->where('user_id', Auth::user()->id)->first();
                    if ($isProductExist) {
                        // update
                        Cart::where('id', $isProductExist->id)->update([
                            'quantity'  =>  $value['quantity'] ?  $value['quantity'] : $isProductExist->quantity + 1,
                            'price'     =>  $value['price'],
                            'date'      => date('Y-m-d h:i'),
                            'cartData'  => json_encode($value['productData']),
                        ]);
                    } else {
                        // create
                        $isProductExist = Cart::create([
                            'user_id'       => Auth::user()->id,
                            'quantity'  =>  $value['quantity'] ?  $value['quantity'] : $isProductExist->quantity + 1,
                            'price'     =>  $value['price'],
                            'date'      => date('Y-m-d h:i'),
                            'cartData'  => json_encode($value['productData']),
                            'product_child_id'  => $value['productId'],
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return response()->json([
                'success'   => false,
                'data'      => [],
                'message'   => $th->getMessage(),
            ], 500);
        }
        return response()->json([
            'success'   => true,
            'data'      => Cart::where('user_id', Auth::user()->id)->get(),
            'message'   => 'Data found',
        ], 200);
        
    }
}
