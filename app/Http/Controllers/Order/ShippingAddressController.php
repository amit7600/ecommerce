<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShippingAddress;
use Auth;
use DB;

class ShippingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippingAddress = ShippingAddress::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Data found',
            'data'      => $shippingAddress,
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
        $this->validate($request, [
            'first_name' => 'required',
            'mobile_number' => 'required',
            'address'   => 'required',
            'city'  => 'required',
            'state' => 'required',
            'address_type'  => 'required',
        ]);

        try {
            DB::beginTransaction();
            $request['user_id'] = Auth::user()->id;
            $shipp = ShippingAddress::create($request->all());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => $th->getMessage(),
                'data'      => [],
            ]);
            //throw $th;
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Data found',
            'data'      => $shipp,
        ]);
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
        $this->validate($request, [
            'first_name' => 'required',
            'mobile_number' => 'required',
            'address'   => 'required',
            'city'  => 'required',
            'state' => 'required',
            'address_type'  => 'required',
        ]);

        try {
            DB::beginTransaction();
            $request['user_id'] = Auth::user()->id;
            $shipp = ShippingAddress::where('id', $id)->update($request->all());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'   => $th->getMessage(),
                'data'      => [],
            ]);
            //throw $th;
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Data found',
            'data'      => ShippingAddress::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ShippingAddress::destroy($id);
        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => 'Data found',
                'data'      => [],
            ], 500);    
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Deleted',
            'data'      => [],
        ], 200);
    }
}
