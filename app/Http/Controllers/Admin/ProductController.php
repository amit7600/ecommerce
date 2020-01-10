<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Model\Attributes;
use App\Model\ChildAttribute;
use App\Model\ProductSpecification;
use App\Model\Products;
use App\Model\Category;
use App\Model\ChildProducts;
use App\Model\Tax;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::get();
        return view('Admin.product_management.products.index', compact('products'));
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
        $tax = Tax::where('status', '1')->get();
        foreach ($tax as $key => $value) {
            $value->tax_name = $value->tax_name . ' (' . $value->tax_rate . '%)';
            $value->tax_name_arabic = $value->tax_name_arabic . ' (' . $value->tax_rate . '%)';
        }
        $tax = $tax->pluck('tax_name'.$name, 'id');
        $category = Category::pluck('category_name'.$name, 'id');
        
        $attributes = Attributes::get();
        $childAttributes = ChildAttribute::get();
        return view('Admin.product_management.products.create', compact('category', 'tax', 'attributes', 'childAttributes'));
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
            'product_name'  => 'required',
            'product_code'  => 'required',
            'product_description'  => 'required',
            'category'  => 'required',
            // 'tax'  => 'required',
            'status'  => 'required',
            // 'price_*'  => 'required',
            // 'sales_price'  => '',
            'product_image'  => 'required',
            // 'product_image_arabic_0'  => 'required',
        ]);
        $p = 0;
        // $productAttribute = [];
        foreach ($request->all() as $key => $value) {
            // loop for fetch the request and upload image and store data to the product child table
            if($request->has('price_'.$p) and $request->get('price_'.$p) == null) {
                return redirect()->back()->with('error', __('language.priceRequired'))->withInput($request->all());
            }
            if($request->has('sale_price_'.$p) and $request->get('sale_price_'.$p) != null && $request->get('sale_price_'.$p) > $request->get('price_'.$p)) {
                return redirect()->back()->with('error', __('language.salePriceLess'))->withInput($request->all());
            }
            $p++;
        }
        try {
            DB::beginTransaction();
            // values for store data to the product table
            $poiImplode = null;
            $productOtherImage = [];
            if ($request->hasFile('product_image')) {
                // for product other image upload
                $files = $request->file('product_image');
                foreach($files as $file){
                    $productOtherImage[] = $this->uploadImage($file); // call to uplod function
                }
                if(count($productOtherImage) > 0){
                    // for product other image implode to store data
                    $poiImplode = implode(',', $productOtherImage);
                }
            }
            $description = $request->get('product_description');
            $descriptionArabic = $request->get('product_description_arabic');
            $description = str_replace("\t", '', $description);
            $description = str_replace("\r", '', $description);
            $descriptionArabic = str_replace("\t", '', $descriptionArabic);
            $descriptionArabic = str_replace("\r", '', $descriptionArabic);
            // dd($description, $descriptionArabic);
            $values = [
                'product_name'  => $request->get('product_name'),
                'product_name_arabic'  => $request->get('product_name_arabic'),
                'product_code'  => $request->get('product_code'),
                'product_description'  => $description,
                'product_description_arabic'  => $descriptionArabic,
                'category_id'  => $request->get('category'),
                'tax_id'  => $request->get('tax'),
                'status'  => $request->get('status'),
                'product_other_image'   => $poiImplode,
                'is_latest'            => $request->has('is_latest') ? 1 : null,
                'is_futured'           => $request->has('is_futured') ? 1 : null,
                'created_by'    => Auth::user()->id,
            ];
            // dd($values);
            $productCreate = Products::create($values);
            // call to the createChild function
            $this->createChild($request, $productCreate->id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();
            //throw $th;
        }
        return redirect()->to('products')->with('success', __('language.productAlert').' '.__('language.alertMessage.created'));
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
        $product = Products::whereId($id)->first();
        $name = '';
        if(app()->getLocale() == 'ar') {
            $name = '_arabic';
        }
        $tax = Tax::where('status', '1')->get();
        foreach ($tax as $key => $value) {
            $value->tax_name = $value->tax_name . ' (' . $value->tax_rate . '%)';
            $value->tax_name_arabic = $value->tax_name_arabic . ' (' . $value->tax_rate . '%)';
        }
        $tax = $tax->pluck('tax_name'.$name, 'id');
        $category = Category::pluck('category_name'.$name, 'id');
        
        $attributes = Attributes::get();
        $childAttributes = ChildAttribute::get();
        $product->product_other_image = $product->product_other_image ? explode(',', $product->product_other_image) : [];
        return view('Admin.product_management.products.edit', compact('category', 'tax', 'attributes', 'childAttributes', 'product'));
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
        // dd($request->all());
        $this->validate($request, [
            'product_name'  => 'required',
            'product_code'  => 'required',
            'product_description'  => 'required',
            'category'  => 'required',
            'status'  => 'required',
        ]);

        try {
            $childData = Products::whereId($id)->first();

            DB::beginTransaction();
            $i = 0;
            $productAttribute = [];
            $exProductImage = $childData->product_other_image ? explode(',', $childData->product_other_image) : null;
            if($request->has('removeImages') and $request->get('removeImages') != null) {
                $ex = explode(',', $request->get('removeImages'));
                $newArray = array_diff($exProductImage, $ex); //remove from array
            }
            // remove product specification
            if($request->has('removeSpecification') and $request->get('removeSpecification') != null) {
                $exSpeci = explode(',', $request->get('removeSpecification'));
                $newArray = array_diff($exProductImage, $exSpeci); //remove from array
            }

            if ($request->hasFile('product_image')) {
                // for product other image upload
                $files = $request->file('product_image');
                foreach($files as $file){
                    $productOtherImageTemp[] = $this->uploadImage($file); // call to uplod function
                }
            }
            
            if($request->hasFile('product_image')) {
                if(isset($newArray) && count($newArray) == 0) {
                    // remove image in exists in request
                    $newArray = $productOtherImageTemp;
                } elseif (isset($newArray) && count($newArray) > 0) {
                    $newArray = array_merge_recursive($productOtherImageTemp, $newArray);
                } else {
                    if($exProductImage) {
                        $newArray = array_merge_recursive($exProductImage, $productOtherImageTemp);
                    } else {
                        $newArray = $productOtherImageTemp;
                    }
                }
            } else {
                if(isset($newArray) && count($newArray) == 0) {
                    // remove image in exists in request
                    $newArray = [];
                } elseif (isset($newArray) && count($newArray) > 0) {
                    $newArray = $newArray;
                } else {
                    $newArray = $exProductImage;
                }
            }
            // values for store data to the product table
            $values = [
                'product_name'  => $request->get('product_name'),
                'product_name_arabic'  => $request->get('product_name_arabic'),
                'product_code'  => $request->get('product_code'),
                'product_description'  => $request->get('product_description'),
                'product_description_arabic'  => $request->get('product_description_arabic'),
                'product_other_image'      => (count($newArray) > 0) ? implode(',', $newArray) : null,
                'category_id'  => $request->get('category'),
                'tax_id'  => $request->get('tax'),
                'status'  => $request->get('status'),
                'is_latest'            => $request->has('is_latest') ? 1 : null,
                'is_futured'           => $request->has('is_futured') ? 1 : null,
                'updated_by'    => Auth::user()->id,
            ];
            $productUpdate = Products::whereId($id)->update($values);
            if (count($childData->getChildProduct) > 0) {
                
                $i = 0;
                $j = 0;
                $productAttribute = [];
                // remove child from child table
                if($request->has('removeIds') && $request->get('removeIds') != '') {
                    $explodeRemove = explode(',', $request->get('removeIds'));
                    if (count($explodeRemove) > 0) {
                        foreach ($explodeRemove as $keyR => $valueR) {
                            ChildProducts::destroy($valueR);
                        }
                    }
                }
                // remove product specification
                if($request->has('removeSpecification') && $request->get('removeSpecification') != '') {
                    $explodeRemove = explode(',', $request->get('removeSpecification'));
                    if (count($explodeRemove) > 0) {
                        foreach ($explodeRemove as $keyR => $valueR) {
                            ProductSpecification::destroy($valueR);
                        }
                    }
                }
                foreach ($request->all() as $key => $value) {
                    $isNewAttribute = false;
                    $productOtherImage = [];
                    $productOtherImageArabic = [];
                    $productImage = null;
                    $productImageArabic = null;
                    $poiImplode = null; //product Other image
                    $poiaImplode = null; //product Other image arabic
                    // loop for fetch the request and upload image and store data to the product child table
                    
                    if($request->has('price_'.$i)) {
                        if ($request->hasFile('product_image_'.$i)) {
                            // for product image upload
                            $image = $request->file('product_image_'.$i);
                            $productImage = $this->uploadImage($image); // call to uplod function
                        }
                        if ($request->hasFile('product_other_image_'.$i)) {
                            // for product other image upload
                            $files = $request->file('product_other_image_'.$i);
                            foreach($files as $file){
                                $productOtherImage[] = $this->uploadImage($file); // call to uplod function
                            }
                            if(count($productOtherImage) > 0)
                                // for product other image implode to store data
                                $poiImplode = implode(',', $productOtherImage);
                        }
                        if ($request->hasFile('product_image_arabic_'.$i)) {
                            $image = $request->file('product_image_arabic_'.$i);
                            $productImageArabic = $this->uploadImage($image); // call to uplod function
                        }
                        if ($request->hasFile('product_other_image_arabic_'.$i)) {
                            $files = $request->file('product_other_image_arabic_'.$i);
                            foreach($files as $file) {
                                $productOtherImageArabic[] = $this->uploadImage($file); // call to uplod function
                            }
                            if(count($productOtherImageArabic) > 0)
                            // for product other image Arabic implode to store data
                                $poiaImplode = implode(',', $productOtherImageArabic);
                        }
                        $attributes = [];
                        // if existing attribute
                        if ($request->has('attribute_'.$i)) {
                            foreach ($request->get('attribute_'.$i) as $keyl => $valuel) {
                                if($valuel != null) {
                                    $attributes[] = $valuel;
                                }
                            }
                            $attributes = implode(',', $attributes);
                        }
                        // if new attribute
                        if ($request->has('newattribute_'.$i)) {
                            $isNewAttribute = true;
                            foreach ($request->get('newattribute_'.$i) as $keyl => $valuel) {
                                if($valuel != null) {
                                    $attributes[] = $valuel;
                                }
                            }
                            $attributes = implode(',', $attributes);
                        }
                        // dd($productImage, $productImageArabic, $poiImplode, $poiaImplode);
                        $childValue = [
                            'product_id'    => $id,
                            'child_attribute_ids'   => $attributes,
                            'price'             => $request->get('price_'.$i),
                            'sale_price'        => $request->get('sale_price_'.$i),
                            'product_image'     => $productImage,
                            'product_image_arabic'  => $productImageArabic,
                            'product_other_image'   => $poiImplode,
                            'product_other_image_arabic'    => $poiaImplode,
                        ];
                         if ($isNewAttribute) {
                            //  dd($isNewAttribute);
                            ChildProducts::create($childValue);
                            DB::commit();
                         } else {
                            //  update
                            $childId = $childData->getChildProduct[$j]->id;
                            $childProduct = ChildProducts::whereId($childId)->first();
                            $childValue = [
                                'product_id'    => $id,
                                'child_attribute_ids'   => $attributes,
                                'price'             => $request->get('price_'.$i),
                                'sale_price'        => $request->get('sale_price_'.$i),
                                'product_image'     => $productImage ? $productImage : $childProduct->product_image,
                                'product_image_arabic'  => $productImageArabic ? $productImageArabic : $childProduct->product_image_arabic,
                                'product_other_image'   => $childProduct->product_other_image ? $poiImplode ? $childProduct->product_other_image.','.$poiImplode:$childProduct->product_other_image : $poiImplode,
                                'product_other_image_arabic'    => $childProduct->product_other_image_arabic ? $poiaImplode ? $childProduct->product_other_image_arabic.','.$poiaImplode:$childProduct->product_other_image_arabic : $poiaImplode,
                            ];
                            $a = ChildProducts::where('id', $childId)->update($childValue);
                            DB::commit();
                            $j++;
                         }
                    }
                    $i++;
                    // dd($request->all());
                }
            } else {
                $this->createChild($request, $id);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', __('language.alertMessage.internalServerError'))->withInput();
        }
        return redirect()->to('products')->with('success', __('language.productAlert').' '.__('language.alertMessage.updated'));
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
            Products::destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => __('language.alertMessage.internalServerError')]);
        }
        
        return response()->json(['success' =>  __('language.productAlert').' '.__('language.alertMessage.deleted')]);
    }

    public function uploadImage($image)
    {
        $tempname = explode('.', $image->getClientOriginalName());
        $tempname = str_replace(' ', '_', $tempname);
        $name = $tempname[0].'_'.time().'.'.$image->getClientOriginalExtension();
        // $path = 'uploads/book'.$request->get('bookId').'/'.$request->get('coverPage');
        $path = '/uploads/Products';
        $destinationPath = public_path($path);
        $imagePath = $destinationPath. "/". $name;
        $image->move($destinationPath, $name);
        return $path.'/'.$name;
    }

    /**
     * Create record the specified resource from storage.
     *
     * @param  int  $id=product id, $request
     * @return \Illuminate\Http\Response
     */
    public function createChild($request, $id)
    {
        $i = 0;
        $productAttribute = [];
        foreach ($request->all() as $key => $value) {
            // loop for fetch the request and upload image and store data to the product child table
            $productOtherImage = [];
            $productOtherImageArabic = [];
            $productImage = null;
            $productImageArabic = null;
            $poiImplode = null; //product Other image
            $poiaImplode = null; //product Other image arabic
            $key = [];
            $value = [];
            
            if($request->has('price_'.$i)) {
                if ($request->hasFile('product_image_'.$i)) {
                    // for product image upload
                    $image = $request->file('product_image_'.$i);
                    $productImage = $this->uploadImage($image); // call to uplod function
                }
                if ($request->hasFile('product_other_image_'.$i)) {
                    // for product other image upload
                    $files = $request->file('product_other_image_'.$i);
                    foreach($files as $file){
                        $productOtherImage[] = $this->uploadImage($file); // call to uplod function
                    }
                    if(count($productOtherImage) > 0)
                        // for product other image implode to store data
                        $poiImplode = implode(',', $productOtherImage);
                }
                if ($request->hasFile('product_image_arabic_'.$i)) {
                    $image = $request->file('product_image_arabic_'.$i);
                    $productImageArabic = $this->uploadImage($image); // call to uplod function
                }
                if ($request->hasFile('product_other_image_arabic_'.$i)) {
                    $files = $request->file('product_other_image_arabic_'.$i);
                    foreach($files as $file) {
                        $productOtherImageArabic[] = $this->uploadImage($file); // call to uplod function
                    }
                    if(count($productOtherImageArabic) > 0)
                    // for product other image Arabic implode to store data
                        $poiaImplode = implode(',', $productOtherImageArabic);
                }
                $attributes = [];
                if ($request->has('attribute_'.$i)) {
                    foreach ($request->get('attribute_'.$i) as $keyl => $valuel) {
                        if($valuel != null) {
                            $attributes[] = $valuel;
                        }
                    }
                    $attributes = implode(',', $attributes);
                }
                ChildProducts::create([
                    'product_id'    => $id,
                    'child_attribute_ids'   => $attributes,
                    'price'             => $request->get('price_'.$i),
                    'sale_price'        => $request->get('sale_price_'.$i),
                    'product_image'     => $productImage,
                    'product_image_arabic'  => $productImageArabic,
                    'product_other_image'   => $poiImplode,
                    'product_other_image_arabic'    => $poiaImplode,
                ]);
            }
            if ($request->has('key_'.$i) and $request->has('value_'.$i)) {
                ProductSpecification::create([
                    'product_id'    => $id,
                    'key'           => $request->get('key_'.$i),
                    'value'         => $request->get('value_'.$i),
                ]);
            }
            $i++;
            // dd($request->all());
        }
    }

    /**
     * Store image record the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function imageUpload()
    {
        return view('Admin.product_management.products.image_upload');
    }

    /**
     * Display a form of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request)
    {
        $files = $request->file('product_image');
        // dd($files);
        $imagePath = [];
        foreach($files as $file) {
            $imagePath[] = $this->uploadImage($file); // call to uplod function
        }
        return view('Admin.product_management.products.image_upload', compact('imagePath'));
    }
    
    /**
     * Store product import export.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function importExport()
    {
        return view('Admin.product_management.products.importExport');
    }
}
