<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Category;
use App\Model\Tax;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryDetails = Category::get();
        return view('Admin.category.index', compact('categoryDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = '';
        if(app()->getLocale() == 'ar') {
            $name = '_arabic';
        }
        $tax = Tax::where('status','1')->pluck('tax_name'.$name, 'id');
        $parentCategory = Category::where('parent_category', '0')->where('status','1')->pluck('category_name'.$name, 'id');
        // dd($tax, $parentCategory);
        return view('Admin.category.create', compact('tax', 'parentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'category_name' => 'required',
            'category_name_arabic' => 'required',
            'status'        => 'required',
        ]);

        try {
            DB::beginTransaction();
            $categoryImage = '';
            if ($request->hasFile('category_image')) {
            // for product other image upload
                $file = $request->file('category_image');
                    $categoryImage = $this->uploadImage($file); // call to uplod function
            }
            $requestData = [
                'parent_category'   => $request->get('parent_category') ? $request->get('parent_category') : 0,
                'category_name'     => $request->get('category_name'),
                'category_name_arabic'     => $request->get('category_name_arabic'),
                'category_image'        => $categoryImage,
                'tax_id'            => $request->get('tax'),
                'status'            => $request->get('status'),
                'created_by'    => Auth::user()->id,
            ];
            Category::create($requestData);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
            //throw $th;
        }
        return redirect()->to('category')->with('success', __('language.category').' '.__('language.alertMessage.created'));
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
        $name = '';
        if(app()->getLocale() == 'ar') {
            $name = '_arabic';
        }
        $tax = Tax::where('status','1')->pluck('tax_name'.$name, 'id');
        $parentCategory = Category::where('parent_category', '0')->where('status','1')->pluck('category_name'.$name, 'id');
        $categoryData = Category::whereId($id)->first();
        // dd($tax, $parentCategory, $categoryData);
        return view('Admin.category.edit', compact('tax', 'parentCategory', 'categoryData'));
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
            'category_name' => 'required',
            'category_name_arabic' => 'required',
            'status'        => 'required',
        ]);

        try {
            DB::beginTransaction();
            $categoryImage = '';
            if ($request->hasFile('category_image')) {
            // for product other image upload
                $file = $request->file('category_image');
                    $categoryImage = $this->uploadImage($file); // call to uplod function
            } else {
                $cat = Category::whereId($id)->first();
                $categoryImage = $cat->category_image;
            }
        
            $requestData = [
                'parent_category'   => $request->get('parent_category') ? $request->get('parent_category') : 0,
                'category_name'     => $request->get('category_name'),
                'category_name_arabic'     => $request->get('category_name_arabic'),
                'tax_id'            => $request->get('tax'),
                'status'            => $request->get('status'),
                'category_image'        => $categoryImage,
                'updated_by'    => Auth::user()->id,
            ];
            Category::where('id', $id)->update($requestData);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', __('language.alertMessage.internalServerError'));
            //throw $th;
        }
        return redirect()->to('category')->with('success', __('language.category').' '.__('language.alertMessage.updated'));
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
            Category::destroy($id);
        } catch (\Throwable $th) {
            return response()->json(['error' => __('language.alertMessage.internalServerError')]);
        }
        return response()->json(['success' =>  __('language.category').' '.__('language.alertMessage.deleted')]);
    }
    public function uploadImage($image)
    {
        $tempname = explode('.', $image->getClientOriginalName());
        $tempname = str_replace(' ', '_', $tempname);
        $name = $tempname[0].'_'.time().'.'.$image->getClientOriginalExtension();
        // $path = 'uploads/book'.$request->get('bookId').'/'.$request->get('coverPage');
        $path = '/uploads/Category';
        $destinationPath = public_path($path);
        $imagePath = $destinationPath. "/". $name;
        $image->move($destinationPath, $name);
        return $path.'/'.$name;
    }
}
