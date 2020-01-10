<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\EmailSMSController;
use App\User;
use App\Model\EmailTemplate;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct(EmailSMSController $EmailSMSController) {
        $this->EmailSMSController = $EmailSMSController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
			'mobile_number' => 'required',
        ]);
        // return response()->json(['kandarp pandya']);
        try{
			DB::beginTransaction();
			$users = User::create([
				'first_name'  => $request->get('first_name'),
				'first_name_arabic' => $request->get('first_name_arabic'),
				'last_name' => $request->get('last_name'),
				'last_name_arabic' => $request->get('last_name_arabic'),
				'email' => $request->get('email'),
				'password' => \Hash::make($request->get('password')),
				'country_code' => $request->get('country_code'),
				'mobile_number' => $request->get('mobile_number'),
				'role_id' => 3,
				'status' => '1',
				'api_token' => str_random(60)
			]);
			$EmailTemplate = EmailTemplate::whereId(1)->first();
            if($EmailTemplate) {
                $data = array(
                    '{var_first_name}' => $request->get('first_name'),
                    '{var_last_name}'  => $request->get('last_name'),
                    '{var_email}' 	   => $request->get('email'),
                    '{var_mobile_number}' => $request->get('mobile_number'),
                    'to'				=> $request->get('email'),
                    'subject'			=> $EmailTemplate->email_subject
                );
                $body = $EmailTemplate->email_body;
                foreach($data as $key=> $value){
                    $body = str_replace($key,$value,$body);
                }
                $this->EmailSMSController->send_email($body,$data);
            }
            Auth::loginUsingId($users->id);
            $user = Auth::user();
            $token = $user->createToken('Ecommerce')->accessToken;
			DB::commit();
		}catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'message'     => __('language.alertMessage.internalServerError'),
                'data'      => [],
                'accessToken'   => '',
            ], 500);
        }
        return response()->json([
            'success'   => true,
            'message'     => 'Authenticated!',
            'data'      => $users,
            'accessToken'   => $token,
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
    public function myProfileUpdate(Request $request){
        $this->validate($request,[
                'first_name'    =>  'required',
                'last_name'     =>  'required',
                'mobile_number' =>  'required',
                'country_code'  =>  'required'
            ]);
        try{
            DB::beginTransaction();

            $user = User::where('id', Auth::id())->update([
                        'first_name'    =>  $request->first_name,
                        'last_name'     =>  $request->last_name,
                        'mobile_number' =>  $request->mobile_number,
                        'country_code'  =>  $request->country_code
                    ]);

            DB::commit();

            }catch(Throwable $th){
                DB::rollback();

                    return response()->json([
                    'success'   => false,
                    'message'     => __('language.alertMessage.internalServerError'),
                    'data'      => [],
                    'accessToken'   => '',
                ], 500);
            }

        return response()->json([
            'message' => __('language.profile').' '.__('language.alertMessage.updated'),
            'success' => true,
        ],200);
    }

    public function userData(){
        $user = User::where('id',Auth::id())->first();

        return response()->json([
            'data' => $user
        ],200);
    }
    public function changePassword(Request $request){
        
        $this->validate($request,[
            'old_password'      => 'required',
            'password'          => 'required|confirmed'
        ]);
        try{
            DB::beginTransaction();

            $user = User::findOrFail(Auth::id());
            if (\Hash::check($request->get('old_password'), $user->password)) {
                User::whereId(Auth::user()->id)->update([
                        'password' => \Hash::make($request->get('password'))
                    ]);
                DB::commit();
            } else {
                return response()->json([
                    'success'       => false,
                    'message'       => 'Old password is not match!',
                    'data'          => [],
                ]);
            }
        } catch (Throwable $th) {
            DB::rollBack();
                return response()->json([
                'success'   => false,
                'message'     => __('language.alertMessage.internalServerError'),
                'data'      => [],
                'accessToken'   => '',
            ], 500);
        }
        return response()->json([
            'message' => __('language.password').' '.__('language.alertMessage.updated'),
            'success' => true,
        ],200);

    }
}
