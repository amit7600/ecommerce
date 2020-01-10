<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\EmailTemplate;
use App\User;
use DB;
use Illuminate\Http\Request;
use Mail;
use Auth;

class EmailTemplateController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$emailtemplates = EmailTemplate::get();

		return view('Admin.email_template.index', compact('emailtemplates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('Admin.email_template.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'email_subject' => 'required',
			'email_body' => 'required',
		]);

		try {
			DB::beginTransaction();

			EmailTemplate::create([
				'name' => $request->get('name'),
				'email_subject' => $request->get('email_subject'),
				'email_body' => $request->get('email_body'),
				'status' => $request->get('status'),
				'created_by'    => Auth::user()->id,
			]);
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();
		}
		return redirect()->to('email_template')->with('success', __('language.emailtemplate') . ' ' . __('language.alertMessage.created'));

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
		$emailtemplates = EmailTemplate::where('id', $id)->first();
		// dd($emailtemplates);
		return view('Admin.email_template.edit', compact('emailtemplates'));
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
			'email_subject' => 'required',
			'email_body' => 'required',
		]);
		try {
			DB::beginTransaction();

			EmailTemplate::whereId($id)->update([
				'name' => $request->get('name'),
				'email_subject' => $request->get('email_subject'),
				'email_body' => $request->get('email_body'),
                'updated_by'    => Auth::user()->id,
			]);
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();

			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();
		}

		return redirect()->to('email_template')->with('success', __('language.emailtemplate') . ' ' . __('language.alertMessage.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//delete the email template from database.
		EmailTemplate::destroy($id);

		return response()->json(['success' => __('language.templateAlert') . ' ' . __('language.alertMessage.deleted')]);
	}
	public function status(Request $request, $id) {
		
		try {
			//update the email template status from database.
			EmailTemplate::where('id', $id)->update([
				'status' => $request->get('status'),
			]);
			return response()->json([
				'success' => __('language.templateAlert') . ' ' . __('language.alertMessage.statusChange'),
			]);
		} catch (Exception $e) {
			return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
		}
	}

	public function send_email(Request $request, $id) {
		// dd($request);
		$user = User::whereId($id)->first();
		$body = EmailTemplate::whereId('3')->first();

		$data['var_array'] = array('{var_first_name}' => $user->name,
			'{var_email}' => $user->email,
		);

		$from = env('MAIL_FROM_ADDRESS', 'hello@example.com');
		$name = env('amit solanki');
		$to = $user->email;
		$emailBody = $body->email_body;
		$subject = $body->email_subject;
		foreach ($data['var_array'] as $key => $value) {
			$emailBody = str_replace($key, $value, $body);
		}
		// dd($body->email_subject);
		// Mail::send(array(), array('name' => $name), function ($message) use ($from, $to, $subject, $emailBody) {

		// 	$message->from($from);
		// 	$message->to($to)->subject($subject);
		// 	$message->setBody($emailBody, 'text/html'); // for HTML rich messages
		// });
		// return "Your email has been sent successfully";
		Mail::send('email', $data, function ($message) use ($to, $subject, $from) {
			$message->to($to)->subject
				($subject);
			$message->from($from);
		});
		echo "HTML Email Sent. Check your inbox.";
	}
}