<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Roles;
use DB;
use Auth;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = DB::table('menus')->get();
        $rolesDetails = Roles::paginate(10);
        return view('Admin.roles.index', compact('rolesDetails','menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = DB::table('menus')->get();
        return view('Admin.roles.create',compact('menus'));
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
            'role_name'          => 'required|max:50',
            'role_name_arabic'   => 'required|max:50',
        ]);
        try {
            $permissions = '';
			if($request->has('permissions')){
				$permissions = implode(',',$request->get('permissions'));
				// dd($permissions);
			}
            Roles::create([
                'role_name' => $request->get('role_name'),
                'role_name_arabic' => $request->get('role_name_arabic'),
                'created_by'=> \Auth::user()->id,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
        }
        return redirect()->to('roles')->with('success',  __('language.role').' '.__('language.alertMessage.created'));
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
        $roles = Roles::whereId($id)->first();
        $menus = DB::table('menus')->get();
        $permission = explode(',',$roles->permissions);
        $rolesDetails = Roles::where('id', $id)->first();
        return view('Admin.roles.edit', compact('rolesDetails','roles','menus'));
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
            'role_name'          => 'required|max:50',
            'role_name_arabic'   => 'required|max:50',
        ]);
        try {
            $permissions = '';
			if($request->has('permissions')){
				$permissions = implode(',',$request->get('permissions'));
				// dd($permissions);
            }
            
            Roles::where('id', $id)->update([
                'role_name' => $request->get('role_name'),
                'role_name_arabic' => $request->get('role_name_arabic'),
                'permissions'      => $permissions
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
        }
        return redirect()->to('roles')->with('success',  __('language.role').' '.__('language.alertMessage.updated'));
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
            Roles::destroy($id);
            return response()->json(['success' =>  __('language.alertMessage.deleted')]);
        } catch (\Exception $e) {
            return response()->json(['error' => __('language.role').' '.__('language.alertMessage.somethingWentWrong')]);
        }
    }
}
