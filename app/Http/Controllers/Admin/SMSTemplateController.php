<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SMSTemplate;
use DB;
use Illuminate\Http\Request;
use Auth;

class SMSTemplateController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$smsTemplates = SMSTemplate::get();

		return view('Admin.sms_template.index', compact('smsTemplates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('Admin.sms_template.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		try {
			DB::beginTransaction();

			$this->validate($request, [
				'name' => 'required',
				'sms_body' => 'required',
			]);

			SMSTemplate::create([
				'name' => $request->get('name'),
				'sms_body' => $request->get('sms_body'),
				'status' => $request->get('status'),
				'created_by'    => Auth::user()->id,
			]);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();

			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();
		}

		return redirect()->to('sms_template')->with('success', __('language.smstemplate') . ' ' . __('language.alertMessage.created'));

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

		$smsTemplates = SMSTemplate::whereId($id)->first();

		return view('Admin.sms_template.edit', compact('smsTemplates'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {

		$this->validate($request, [
			'name' => 'required',
			'sms_body' => 'required',
		]);

		try {
			DB::beginTransaction();

			SMSTemplate::whereId($id)->update([
				'name' => $request->get('name'),
				'sms_body' => $request->get('sms_body'),
                'updated_by'    => Auth::user()->id,
			]);
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();

			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();

		}

		return redirect()->to('sms_template')->with('success', __('language.smstemplate') . ' ' . __('language.alertMessage.updated'));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//delete the data from storage.
		SMSTemplate::destroy($id);

		return response()->json(['success' => __('language.templateAlert') . ' ' . __('language.alertMessage.deleted')]);
	}

	public function status(Request $request, $id) {
		try {

			DB::beginTransaction();
			//update the sms template status from database
			SMSTemplate::whereId($id)->update([
				'status' => $request->get('status'),
			]);

			DB::commit();

		} catch (Exception $e) {
			DB::rollback();

			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
		}

		return response()->json([
			'success' => __('language.smstemplate') . ' ' . __('language.alertMessage.statusChange'),
		]);

	}
}
