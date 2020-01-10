<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Products;
use App\Model\ChildProducts;

class ExcelController extends Controller
{
    public function export()
    {
        try {
            \Excel::create('All_Users', function($excel) {

                $excel->sheet('Sheet 1', function($sheet) {
                    $products=Products::get();
                        foreach($products as $key => $product) {                            
                             $data[] = array(
                                $product->product_name,
                                $product->product_name_arabic,
                                $product->product_code,
                                $product->agency,
                                $product->address,
                                $product->city,
                                $product->state,
                                $product->zip,
                                $product->phone,
                                $product->toll_free_number,
                                $product->member_cst_number,
                                $product->website,
                                $product->roles->role_name,
                            );
                        }
                    $sheet->fromArray($data, null, 'A1', false, false);

                    // set header of excel file
                    $headings = array('PMV', 'Name', 'Email', 'Agency', 'Address', 'City', 'State', 'Zip', 'Phone', 'Toll free number', 'ST#', 'Website', 'Role');
                    $sheet->prependRow(1, $headings);
                });
            })->export('xls');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }   
}
