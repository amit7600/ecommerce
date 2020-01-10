<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Products;
use App\Model\ChildProducts;
use App\Model\ChildAttribute;
use App\Model\Attributes;
use App\Model\ProductSpecification;
use App\Model\ShippingAddress;
use App\Model\Offers;
use App\Model\Category;
use DB;
use Auth;

class GetDataController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function products()
    {
        $product = Products::where('status', '1')->get();
        $latest = [];
        $futured = [];
        foreach ($product as $key => $value) {
            $expProd = explode(',', $value->product_other_image);
            $value->product_other_image = $expProd;
            $value->getChildProduct = $value->getChildProduct;
            // $value->getChildProduct;
            if($value->is_futured == 1) {
                $futured[] = $value;
            }
            if($value->is_latest == 1) {
                $latest[] = $value;
            }
        }

        return response()->json([
            'success'           => true,
            'message'           => 'Data found',
            'data'              => $product,
            'latestProduct'     => $latest,
            'futuredProduct'    => $futured,
        ], 200);
    }

    /**
     * Retrun coupon code value.
     *
     * @return \Illuminate\Contracts\Support\Response
     */

    public function getCoupon(Request $request)
    {
        $this->validate($request, [
            'couponCode' => 'required'
        ]);        
        $couponCode = Offers::where('coupon_code', $request->get('couponCode'))->where('status', '1')->first();
        if($couponCode) {
            return response()->json([
                'success'   => true,
                'message'   => 'Data found',
                'data'      => $couponCode,
            ], 200);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'Coupon not found.',
                'data'      => [],
            ], 500);
        }
    }
    
    /**
     * Retrun country code.
     *
     * @return \Illuminate\Contracts\Support\Response
     */
    public function getCountryCode()
    {
        return response()->json([
            'success'   => true,
            'message'   => 'Data found',
            'data'      => DB::table('countries')->get(),
        ], 200);
    }

    /**
     * Retrun Category data.
     *
     * @return \Illuminate\Contracts\Support\Response
     */
    public function categories()
    {
        $category = Category::where('parent_category', 0)->get();
        foreach ($category as $key => $value) {
            $value->childCategory = Category::where('parent_category', $value->id)->get();
            $value->parent = $value->parent;
            foreach ($value->getPorduct as $keyP => $valueP) {
                $valueP->getChildProduct;
            }
        }
        $allCategory = Category::get();
        foreach ($allCategory as $key => $value) {
            foreach ($value->getPorduct as $keyP => $valueP) {
                $valueP->product_other_image = explode(',', $valueP->product_other_image);
                $valueP->getChildProduct;
            }
        }
        return response()->json([
            'success'   => true,
            'data'      => $category,
            'allcategory'=> $allCategory,
            'message'   => 'category found',
        ], 200);
    }

    public function allCategories()
    {
        $category = Category::get();
        // foreach ($category as $key => $value) {
        //     $value->childCategory = Category::where('parent_category', $value->id)->get();
        //     $value->parent = $value->parent;
        //     foreach ($value->getPorduct as $keyP => $valueP) {
        //         $valueP->getChildProduct;
        //     }
        // }
        return response()->json([
            'success'   => true,
            'data'      => $category,
            'message'   => 'category found',
        ], 200);
    }


    /**
     * Retrun elastic search.
     *
     * @return \Illuminate\Contracts\Support\Response
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $product = Products::join('categories', 'products.category_id', '=', 'categories.id')
                    ->join('product_specifications', 'products.id', '=', 'product_specifications.product_id')
                    // ->join('child_products', 'products.id', '=', 'child_products.product_id')
                    ->where('products.product_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.product_name_arabic', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.product_code', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.product_description', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.product_description_arabic', 'LIKE', '%' . $search . '%')
                    ->orWhere('categories.category_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('categories.category_name_arabic', 'LIKE', '%' . $search . '%')
                    ->orWhere('product_specifications.key', 'LIKE', '%' . $search . '%')
                    ->orWhere('product_specifications.value', 'LIKE', '%' . $search . '%')
                    ->select('products.*', 'categories.category_name', 'categories.category_name_arabic')
                    ->get();
        foreach ($product as $key => $value) {
            // dd($value->getProduct);
            $expProd = explode(',', $value->product_other_image);
            $value->product_other_image = $expProd;
            $child = ChildProducts::where('product_id', $value->id)->first();
            $value->sale_price = $child->sale_price;
            $value->price = $child->price;
            $value->childProductId = $child->id;
            // $value->getChildProduct;
        }
        return response()->json([
            'success'   => true,
            'data'      => $product,
            'message'   => 'Search found',
        ], 200);
    }


    public function productsDetails($id)
    {
        $product = ChildProducts::where('product_id', $id)->get();
        // $items = DB::table('child_products')
        //         ->select("child_products.id"
        //             ,DB::raw("(GROUP_CONCAT(child_attributes.id SEPARATOR ',')) as `child_attributes_id`"))
        //         ->leftjoin("child_attributes","child_attributes.id","=","child_products.child_attribute_ids")
        //         ->groupBy('child_products.id')
        //         ->get();
        //         dd($items);
        
        // For attributes
        $data = \DB::table("child_products")
                ->select("child_products.id", "child_products.price", "child_products.sale_price", "child_products.product_id", "child_products.child_attribute_ids",\DB::raw("GROUP_CONCAT(child_attributes.value) as child_attributes"))
                ->leftjoin("child_attributes",\DB::raw("FIND_IN_SET(child_attributes.id,child_products.child_attribute_ids)"),">",\DB::raw("'0'"))
                ->leftjoin("attributes",'child_attributes.attribute_id', '=', 'attributes.id')
                ->groupBy("child_products.id")
                ->groupBy("child_products.price")
                ->groupBy("child_products.sale_price")
                ->groupBy("child_products.product_id")
                ->groupBy("child_products.child_attribute_ids")
                ->where('child_products.product_id', $id)
                ->get();
        foreach ($data as $key => $value) {
            if ($value->child_attribute_ids) {                
                $child = explode(',', $value->child_attribute_ids);
                if (count($child) > 0) {
                    $array = [];
                    $array2 = [];
                    foreach ($child as $keyC => $valueC) {
                        $att = ChildAttribute::where('id', $valueC)->first();
                        $array[] = $att->getParentAttribute->attribute;
                        $array2[] = $att->getParentAttribute->id;
                    }
                    $value->attribute = implode(',', $array);
                    $value->attributeId = implode(',', $array2);
                }
            }   
        }
        // dd($data);
        $newAr = [];
        // foreach ($data as $key => $value) {
        //     dd
        //     $exAttribute = explode(',', $value->attribute);
        //     $exChildAttribute = explode(',', $value->child_attributes);
        //     $exAttributeId = explode(',', $value->attributeId);
        //     foreach ($exAttributeId as $keyA => $valueA) {
        //         $newAr[] = ['attribute_id' => $valueA,  'value' => $exChildAttribute[$keyA], 'attribute' => $exAttribute[$keyA], 'price' => $value->price, 'sale_price' => $value->sale_price, 'product_id' => $value->product_id];
        //     }
        // }
        // dd($newAr);
        return response()->json([
            'success'   => true,
            'message'   => 'Data found',
            'data'      => $product,
            'child'     => $data,
            'product'   => Products::where('id', $id)->first(),
        ], 200);
    }

    public function getCategory($id)
    {
        $category = Category::where('id', $id)->first();
        
        $category->childCategory = Category::where('parent_category', $category->id)->get();
        $category->parent = $category->parent;
        foreach ($category->getPorduct as $keyP => $valueP) {
            $valueP->getChildProduct;
        }
        return response()->json([
            'success'   => true,
            'data'      => $category,
            'message'   => 'category found',
        ], 200);
    }
    
}
