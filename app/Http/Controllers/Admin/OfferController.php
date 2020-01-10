<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Offers;
use DB;
use Auth;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offers::get();
        return view('Admin.product_management.offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.product_management.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'coupon_code' => 'required',
            // 'discount' => 'required',
            // 'discount_amount' => 'required',
            // 'minimum_oder_amount' => 'required',
            // 'minimum_offer_amount' => 'required',
            'status' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
        ]);

        try {
            DB::beginTransaction();
            unset($request['_token']);
            $request['created_by'] = Auth::user()->id;
            Offers::create($request->all());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('error', $th->getMessage())->withInput();
            //throw $th;
        }
        return redirect()->to('offers')->with('success', __('language.offer').' '.__('language.alertMessage.created'));
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
        $offers = Offers::whereId($id)->first();
        return view('Admin.product_management.offer.edit', compact('offers'));
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
            'coupon_code' => 'required',
            // 'discount' => 'required',
            // 'discount_amount' => 'required',
            // 'minimum_oder_amount' => 'required',
            // 'minimum_offer_amount' => 'required',
            'status' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
            ]);
            
            try {
                DB::beginTransaction();
                unset($request['_token']);
                unset($request['_method']);
                $request['updated_by'] = Auth::user()->id;
                Offers::whereId($id)->update($request->all());
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();
                //throw $th;
            }
            return redirect()->to('offers')->with('success', __('language.offer').' '.__('language.alertMessage.updated'));
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
            Offers::destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => __('language.offer').' '.__('language.alertMessage.internalServerError')]);
        }
        
        return response()->json(['success' =>  __('language.offer').' '.__('language.alertMessage.deleted')]);
    }
}
