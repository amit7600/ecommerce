<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Tax;
use Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxDetails = Tax::get();
        return view('Admin.Tax.index', compact('taxDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.tax.create');
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
            'tax_name'          => 'required',
            'tax_name_arabic'   => 'required',
            'tax_rate'          => 'required',
            // 'tax_description'   => 'required',
            // 'tax_description_arabic'   => 'required',
            'status'            => 'required',
        ]);

        try {
            unset($request['_token']);
            $request['created_by'] = Auth::user()->id;
            Tax::create($request->all());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
        return redirect()->to('tax')->with('success', __('language.tax').' '.__('language.alertMessage.created'));
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
        $taxDetails = Tax::whereId($id)->first();        
        return view('Admin.Tax.edit', compact('taxDetails'));
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
            'tax_name'          => 'required',
            'tax_name_arabic'   => 'required',
            'tax_rate'          => 'required',
            // 'tax_description'   => 'required',
            'status'            => 'required',
            ]);
            
            try {
                \DB::beginTransaction();
                unset($request['_token']);
                unset($request['_method']);
                $request['updated_by'] = Auth::user()->id;
                Tax::whereId($id)->update($request->all());
                \DB::commit();
            } catch (\Throwable $th) {
                \DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage())->withInput();
            }
            return redirect()->to('tax')->with('success', __('language.tax').' '.__('language.alertMessage.updated'));
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
            Tax::destroy($id);
        } catch (\Throwable $th) {
            return response()->json(['error' => __('language.alertMessage.internalServerError')]);
        }
        return response()->json(['success' =>  __('language.tax').' '.__('language.alertMessage.deleted')]);
    }
}
