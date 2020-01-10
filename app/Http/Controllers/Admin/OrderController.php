<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Orders;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$orders = Orders::get();

		return view('Admin.orders.index', compact('orders'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return response()->json($request->get('shipingId'));
		try {
			$value = [
				'status' => $request->get('status'),
				$request->get('status') . '_at' => date('Y-m-d H:i'),
			];
			$order = Orders::whereId($request->get('orderId'))->update($value);
			return response()->json([
				'success' => __('language.order') . ' ' . __('language.alertMessage.statusChange'),
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$orders = Orders::whereId($id)->first();

		return view('Admin.Orders.edit', compact('orders'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}